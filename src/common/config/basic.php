<?php
return [
    "upload" => [
        "maxSize" => 2 * 1024 * 1024, // 2 MiB
        "allowedType" => ["jpg", "txt"],
        "saveTo" => API_PUBLIC . "/uploads",
    ]
];
