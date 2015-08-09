<?php
/*
 * PHP QR Code encoder
 *
 * Input encoding class
 *
 * Based on libqrencode C library distributed under LGPL 2.1
 * Copyright (C) 2006, 2007, 2008, 2009 Kentaro Fukuchi <fukuchi@megaui.net>
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */
 
    define('STRUCTURE_HEADER_BITS',  20);
    define('MAX_STRUCTURED_SYMBOLS', 16);

    class QRinputItem {
    
        public $mode;
        public $size;
        public $data;
        public $bstream;

        public function __construct($mode, $size, $data, $bstream = null) 
        {
            $setData = array_slice($data, 0, $size);
            
            if (count($setData) < $size) {
                $setData = array_merge($setData, array_fill(0,$size-count($setData),0));
            }
        
            if(!QRinput::check($mode, $size, $setData)) {
                throw new Exception('Error m:'.$mode.',s:'.$size.',d:'.join(',',$setData));
                return null;
            }
            
            $this->mode = $mode;
            $this->size = $size;
            $this->data = $setData;
            $this->bstream = $bstream;
        }
        
        //----------------------------------------------------------------------
        public function encodeModeNum($version)
        {
            try {
            
                $words = (int)($this->size / 3);
                $bs = new QRbitstream();
                
                $val = 0x1;
                $bs->appendNum(4, $val);
                $bs->appendNum(QRspec::lengthIndicator(QR_MODE_NUM, $version), $this->size);

                for($i=0; $i<$words; $i++) {
                    $val  = (ord($this->data[$i*3  ]) - ord('0')) * 100;
                    $val += (ord($this->data[$i*3+1]) - ord('0')) * 10;
                    $val += (ord($this->data[$i*3+2]) - ord('0'));
                    $bs->appendNum(10, $val);
                }

                if($this->size - $words * 3 == 1) {
                    $val = ord($this->data[$words*3]) - ord('0');
                    $bs->appendNum(4, $val);
                } else if($this->size - $words * 3 == 2) {
                    $val  = (ord($this->data[$words*3  ]) - ord('0')) * 10;
                    $val += (ord($this->data[$words*3+1]) - ord('0'));
                    $bs->appendNum(7, $val);
                }

                $this->bstream = $bs;
                return 0;
                
            } catch (Exception $e) {
                return -1;
            }
        }
        
        //----------------------------------------------------------------------
        public function encodeModeAn($version)
        {
            try {
                $words = (int)($this->size / 2);
                $bs = new QRbitstream();
                
                $bs->appendNum(4, 0x02);
                $bs->appendNum(QRspec::lengthIndicator(QR_MODE_AN, $version), $this->size);

                for($i=0; $i<$words; $i++) {
                    $val  = (int)QRinput::lookAnTable(ord($this->data[$i*2  ])) * 45;
                    $val += (int)QRinput::lookAnTable(ord($this->data[$i*2+1]));

                    $bs->appendNum(11, $val);
                }

                if($this->size & 1) {
                    $val = QRinput::lookAnTable(ord($this->data[$words * 2]));
                    $bs->appendNum(6, $val);
                }
        
                $this->bstream = $bs;
                return 0;
            
            } catch (Exception $e) {
                return -1;
            }
        }
        
        //----------------------------------------------------------------------
        public function encodeMode8($version)
        {
            try {
                $bs = new QRbitstream();

                $bs->appendNum(4, 0x4);
                $bs->appendNum(QRspec::lengthIndicator(QR_MODE_8, $version), $this->size);

                for($i=0; $i<$this->size; $i++) {
                    $bs->appendNum(8, ord($this->data[$i]));
                }

                $this->bstream = $bs;
                return 0;
            
            } catch (Exception $e) {
                return -1;
            }
        }
        
        //----------------------------------------------------------------------
        public function encodeModeKanji($version)
        {
            try {

                $bs = new QRbitrtream();
                
                $bs->appendNum(4, 0x8);
                $bs->appendNum(QRspec::lengthIndicator(QR_MODE_KANJI, $version), (int)($this->size / 2));

                for($i=0; $i<$this->size; $i+=2) {
                    $val = (ord($this->data[$i]) << 8) | ord($this->data[$i+1]);
                    if($val <= 0x9ffc) {
                        $val -= 0x8140;
                    } else {
                        $val -= 0xc140;
                    }
                    
                    $h = ($val >> 8) * 0xc0;
                    $val = ($val & 0xff) + $h;

                    $bs->appendNum(13, $val);
                }

                $this->bstream = $bs;
                return 0;
            
            } catch (Exception $e) {
                return -1;
            }
        }

        //----------------------------------------------------------------------
        public function encodeModeStructure()
        {
            try {
                $bs =  new QRbitstream();
                
                $bs->appendNum(4, 0x03);
                $bs->appendNum(4, ord($this->data[1]) - 1);
                $bs->appendNum(4, ord($this->data[0]) - 1);
                $bs->appendNum(8, ord($this->data[2]));

                $this->bstream = $bs;
                return 0;
            
            } catch (Exception $e) {
                return -1;
            }
        }
        
        //----------------------------------------------------------------------
        public function estimateBitStreamSizeOfEntry($version)
        {
            $bits = 0;

            if($version == 0) 
                $version = 1;

            switch($this->mode) {
                case QR_MODE_NUM:        $bits = QRinput::estimateBitsModeNum($this->size);    break;
                case QR_MODE_AN:        $bits = QRinput::estimateBitsModeAn($this->size);    break;
                case QR_MODE_8:            $bits = QRinput::estimateBitsMode8($this->size);    break;
                case QR_MODE_KANJI:        $bits = QRinput::estimateBitsModeKanji($this->size);break;
                case QR_MODE_STRUCTURE:    return STRUCTURE_HEADER_BITS;            
                default:
                    return 0;
            }

            $l = QRspec::lengthIndicator($this->mode, $version);
            $m = 1 << $l;
            $num = (int)(($this->size + $m - 1) / $m);

            $bits += $num * (4 + $l);

            return $bits;
        }
        
        //----------------------------------------------------------------------
        public function encodeBitStream($version)
        {
            try {
            
                unset($this->bstream);
                $words = QRspec::maximumWords($this->mode, $version);
                
                if($this->size > $words) {
                
                    $st1 = new QRinputItem($this->mode, $words, $this->data);
                    $st2 = new QRinputItem($this->mode, $this->size - $words, array_slice($this->data, $words));

                    $st1->encodeBitStream($version);
                    $st2->encodeBitStream($version);
                    
                    $this->bstream = new QRbitstream();
                    $this->bstream->append($st1->bstream);
                    $this->bstream->append($st2->bstream);
                    
                    unset($st1);
                    unset($st2);
                    
                } else {
                    
                    $ret = 0;
                    
                    switch($this->mode) {
                        case QR_MODE_NUM:        $ret = $this->encodeModeNum($version);    break;
                        case QR_MODE_AN:        $ret = $this->encodeModeAn($version);    break;
                        case QR_MODE_8:            $ret = $this->encodeMode8($version);    break;
                        case QR_MODE_KANJI:        $ret = $this->encodeModeKanji($version);break;
                        case QR_MODE_STRUCTURE:    $ret = $this->encodeModeStructure();    break;
                        
                        default:
                            break;
                    }
                    
                    if($ret < 0)
                        return -1;
                }

                return $this->bstream->size();
            
            } catch (Exception $e) {
                return -1;
            }
        }
    };
    
    //##########################################################################

    class QRinput {

        public $items;
        
        private $version;
        private $level;
        
        //----------------------------------------------------------------------
        public function __construct($version = 0, $level = QR_ECLEVEL_L)
        {
            if ($version < 0 || $version > QRSPEC_VERSION_MAX || $level > QR_ECLEVEL_H) {
                throw new Exception('Invalid version no');
                return NULL;
            }
            
            $this->version = $version;
            $this->level = $level;
        }
        
        //----------------------------------------------------------------------
        public function getVersion()
        {
            return $this->version;
        }
        
        //----------------------------------------------------------------------
        public function setVersion($version)
        {
            if($version < 0 || $version > QRSPEC_VERSION_MAX) {
                throw new Exception('Invalid version no');
                return -1;
            }

            $this->version = $version;

            return 0;
        }
        
        //----------------------------------------------------------------------
        public function getErrorCorrectionLevel()
        {
            return $this->level;
        }

        //----------------------------------------------------------------------
        public function setErrorCorrectionLevel($level)
        {
            if($level > QR_ECLEVEL_H) {
                throw new Exception('Invalid ECLEVEL');
                return -1;
            }

            $this->level = $level;

            return 0;
        }
        
        //----------------------------------------------------------------------
        public function appendEntry(QRinputItem $entry)
        {
            $this->items[] = $entry;
        }
        
        //----------------------------------------------------------------------
        public function append($mode, $size, $data)
        {
            try {
                $entry = new QRinputItem($mode, $size, $data);
                $this->items[] = $entry;
                return 0;
            } catch (Exception $e) {
                return -1;
            }
        }
        
        //----------------------------------------------------------------------
        
        public function insertStructuredAppendHeader($size, $index, $parity)
        {
            if( $size > MAX_STRUCTURED_SYMBOLS ) {
                throw new Exception('insertStructuredAppendHeader wrong size');
            }
            
            if( $index <= 0 || $index > MAX_STRUCTURED_SYMBOLS ) {
                throw new Exception('insertStructuredAppendHeader wrong index');
            }

            $buf = array($size, $index, $parity);
            
            try {
                $entry = new QRinputItem(QR_MODE_STRUCTURE, 3, buf);
                array_unshift($this->items, $entry);
                return 0;
            } catch (Exception $e) {
                return -1;
            }
        }

        //----------------------------------------------------------------------
        public function calcParity()
        {
            $parity = 0;
            
            foreach($this->items as $item) {
                if($item->mode != QR_MODE_STRUCTURE) {
                    for($i=$item->size-1; $i>=0; $i--) {
                        $parity ^= $item->data[$i];
                    }
                }
            }

            return $parity;
        }
        
        //----------------------------------------------------------------------
        public static function checkModeNum($size, $data)
        {
            for($i=0; $i<$size; $i++) {
                if((ord($data[$i]) < ord('0')) || (ord($data[$i]) > ord('9'))){
                    return false;
                }
            }

            return true;
        }

        //----------------------------------------------------------------------
        public static function estimateBitsModeNum($size)
        {
            $w = (int)$size / 3;
            $bits = $w * 10;
            
            switch($size - $w * 3) {
                case 1:
                    $bits += 4;
                    break;
                case 2:
                    $bits += 7;
                    break;
                default:
                    break;
            }

            return $bits;
        }
        
        //----------------------------------------------------------------------
        public static $anTable = array(
            -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
            36, -1, -1, -1, 37, 38, -1, -1, -1, -1, 39, 40, -1, 41, 42, 43,
             0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 44, -1, -1, -1, -1, -1,
            -1, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24,
            25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1
        );
        
        //----------------------------------------------------------------------
        public static function lookAnTable($c)
        {
            return (($c > 127)?-1:self::$anTable[$c]);
        }
        
        //----------------------------------------------------------------------
        public static function checkModeAn($size, $data)
        {
            for($i=0; $i<$size; $i++) {
                if (self::lookAnTable(ord($data[$i])) == -1) {
                    return false;
                }
            }

            return true;
        }
        
        //----------------------------------------------------------------------
        public static function estimateBitsModeAn($size)
        {
            $w = (int)($size / 2);
            $bits = $w * 11;
            
            if($size & 1) {
                $bits += 6;
            }

            return $bits;
        }
    
        //----------------------------------------------------------------------
        public static function estimateBitsMode8($size)
        {
            return $size * 8;
        }
        
        //----------------------------------------------------------------------
        public function estimateBitsModeKanji($size)
        {
            return (int)(($size / 2) * 13);
        }
        
        //----------------------------------------------------------------------
        public static function checkModeKanji($size, $data)
        {
            if($size & 1)
                return false;

            for($i=0; $i<$size; $i+=2) {
                $val = (ord($data[$i]) << 8) | ord($data[$i+1]);
                if( $val < 0x8140 
                || ($val > 0x9ffc && $val < 0xe040) 
                || $val > 0xebbf) {
                    return false;
                }
            }

            return true;
        }

        /***********************************************************************
         * Validation
         **********************************************************************/

        public static function check($mode, $size, $data)
        {
            if($size <= 0) 
                return false;

            switch($mode) {
                case QR_MODE_NUM:       return self::checkModeNum($size, $data);   break;
                case QR_MODE_AN:        return self::checkModeAn($size, $data);    break;
                case QR_MODE_KANJI:     return self::checkModeKanji($size, $data); break;
                case QR_MODE_8:         return true; break;
                case QR_MODE_STRUCTURE: return true; break;
                
                default:
                    break;
            }

            return false;
        }
        
        
        //----------------------------------------------------------------------
        public function estimateBitStreamSize($version)
        {
            $bits = 0;

            foreach($this->items as $item) {
                $bits += $item->estimateBitStreamSizeOfEntry($version);
            }

            return $bits;
        }
        
        //----------------------------------------------------------------------
        public function estimateVersion()
        {
            $version = 0;
            $prev = 0;
            do {
                $prev = $version;
                $bits = $this->estimateBitStreamSize($prev);
                $version = QRspec::getMinimumVersion((int)(($bits + 7) / 8), $this->level);
                if ($version < 0) {
                    return -1;
                }
            } while ($version > $prev);

            return $version;
        }
        
        //----------------------------------------------------------------------
        public static function lengthOfCode($mode, $version, $bits)
        {
            $payload = $bits - 4 - QRspec::lengthIndicator($mode, $version);
            switch($mode) {
                case QR_MODE_NUM:
                    $chunks = (int)($payload / 10);
                    $remain = $payload - $chunks * 10;
                    $size = $chunks * 3;
                    if($remain >= 7) {
                        $size += 2;
                    } else if($remain >= 4) {
                        $size += 1;
                    }
                    break;
                case QR_MODE_AN:
                    $chunks = (int)($payload / 11);
                    $remain = $payload - $chunks * 11;
                    $size = $chunks * 2;
                    if($remain >= 6) 
                        $size++;
                    break;
                case QR_MODE_8:
                    $size = (int)($payload / 8);
                    break;
                case QR_MODE_KANJI:
                    $size = (int)(($payload / 13) * 2);
                    break;
                case QR_MODE_STRUCTURE:
                    $size = (int)($payload / 8);
                    break;
                default:
                    $size = 0;
                    break;
            }
            
            $maxsize = QRspec::maximumWords($mode, $version);
            if($size < 0) $size = 0;
            if($size > $maxsize) $size = $maxsize;

            return $size;
        }
        
        //----------------------------------------------------------------------
        public function createBitStream()
        {
            $total = 0;

            foreach($this->items as $item) {
                $bits = $item->encodeBitStream($this->version);
                
                if($bits < 0) 
                    return -1;
                    
                $total += $bits;
            }

            return $total;
        }
        
        //----------------------------------------------------------------------
        public function convertData()
        {
            $ver = $this->estimateVersion();
            if($ver > $this->getVersion()) {
                $this->setVersion($ver);
            }

            for(;;) {
                $bits = $this->createBitStream();
                
                if($bits < 0) 
                    return -1;
                    
                $ver = QRspec::getMinimumVersion((int)(($bits + 7) / 8), $this->level);
                if($ver < 0) {
                    throw new Exception('WRONG VERSION');
                    return -1;
                } else if($ver > $this->getVersion()) {
                    $this->setVersion($ver);
                } else {
                    break;
                }
            }

            return 0;
        }
        
        //----------------------------------------------------------------------
        public function appendPaddingBit(&$bstream)
        {
            $bits = $bstream->size();
            $maxwords = QRspec::getDataLength($this->version, $this->level);
            $maxbits = $maxwords * 8;

            if ($maxbits == $bits) {
                return 0;
            }

            if ($maxbits - $bits < 5) {
                return $bstream->appendNum($maxbits - $bits, 0);
            }

            $bits += 4;
            $words = (int)(($bits + 7) / 8);

            $padding = new QRbitstream();
            $ret = $padding->appendNum($words * 8 - $bits + 4, 0);
            
            if($ret < 0) 
                return $ret;

            $padlen = $maxwords - $words;
            
            if($padlen > 0) {
                
                $padbuf = array();
                for($i=0; $i<$padlen; $i++) {
                    $padbuf[$i] = ($i&1)?0x11:0xec;
                }
                
                $ret = $padding->appendBytes($padlen, $padbuf);
                
                if($ret < 0)
                    return $ret;
                
            }

            $ret = $bstream->append($padding);
            
            return $ret;
        }

        //----------------------------------------------------------------------
        public function mergeBitStream()
        {
            if($this->convertData() < 0) {
                return null;
            }

            $bstream = new QRbitstream();
            
            foreach($this->items as $item) {
                $ret = $bstream->append($item->bstream);
                if($ret < 0) {
                    return null;
                }
            }

            return $bstream;
        }

        //----------------------------------------------------------------------
        public function getBitStream()
        {

            $bstream = $this->mergeBitStream();
            
            if($bstream == null) {
                return null;
            }
            
            $ret = $this->appendPaddingBit($bstream);
            if($ret < 0) {
                return null;
            }

            return $bstream;
        }
        
        //----------------------------------------------------------------------
        public function getByteStream()
        {
            $bstream = $this->getBitStream();
            if($bstream == null) {
                return null;
            }
            
            return $bstream->toByte();
        }
    }
        
        
    