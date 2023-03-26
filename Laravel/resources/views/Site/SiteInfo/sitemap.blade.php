<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('') }}</loc>
        <priority>1.0</priority>
    </url>
    <?php foreach ($stores as $storeurl) { ?>
        <url>
            <loc>{{ url('view/'.$storeurl->SearchName) }}</loc>
            <priority>0.9</priority>
        </url>
    <?php } ?>


    <?php foreach ($specialPage as $spPage) { ?>
        <url>
            <loc>{{ url('event/'.$spPage->URL) }}</loc>
            <priority>0.8</priority>
        </url>
    <?php } ?>
    <?php foreach ($categories as $caturl) { ?>
        <url>
            <loc>{{ url('category/'.$caturl->SearchName) }}</loc>
            <priority>0.5</priority>
        </url>
    <?php } ?>

</urlset>