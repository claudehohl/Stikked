<?php  echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
    <rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:admin="http://webns.net/mvcb/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:content="http://purl.org/rss/1.0/modules/content/">

        <channel>
        <title>Stikked</title>
        <link><?php echo $feed_url; ?>
        <description><?php echo $page_description; ?></description>
        <dc:language><?php echo $page_language; ?></dc:language>
        <dc:creator><?php echo $creator_email; ?></dc:creator>

        <dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
        <admin:generatoragent rdf:resource="http://www.codeigniter.com/">

        <?php foreach($replies as $paste): ?>

            <item>
<link><?php echo site_url('view/' . $paste['pid']) ?>
              <guid><?php echo site_url('view/' . $paste['pid']) ?></guid>

                <description><[CDATA[ <?php echo $paste['paste']; ?> ]]></description>
<pubdate><?php echo $paste['created']; ?></pubdate>
            </item>

        <?php endforeach; ?>

        </admin:generatoragent></channel>
    </rss>

