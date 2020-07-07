<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?php echo $title ?> - Paste X 代码快速分享</title>
    <meta name="description" content="This is an example of a meta description.">
    <link rel="stylesheet" type="text/css" href="/css/post.css">
</head>

<body>

    <a href="/">
        <h1>Paste X</h1>
    </a>
    <p><span class="meta">title:</span> <?php echo $title ?></p>
    <p><span class="meta">lang:</span> <?php echo $lang ?></p>
    <?php if (isset($comment)) : ?>
        <p><span class="meta">comment:</span> </p>
        <pre class="comment"><?php echo $comment;?></pre>
    <?php endif; ?>
    <p><span class="meta">code:</span> </p>
    <?php echo $highlighted ?>

    <p><span class="meta">created at:</span> <?php echo $createdAt ?></p>
    <script>
        var lines = document.querySelector("code").innerHTML.replace("</span>{", "</span>\n{").split("\n")
        var newLines = [];
        lines.forEach(x => {
            newLines.push(`<span class="line">` + x + `</span>`)
        });
        document.querySelector("code").innerHTML = newLines.join("\n")
    </script>

</body>

</html>