<?php

namespace App\Domain;

use App;

class Post
{
    public const table = "posts";

    public static function create($lang, $title, $content, $uuid, $comment)
    {
        \App::$db->insert(self::table, [
            "lang" => $lang,
            "title" => $title,
            "content" => $content,
            "comment" => $comment,
            "uuid" => $uuid,
            "createdAt" => time(),
        ]);
        return \App::$db->id();
    }
    public static function put($id, $lang, $title, $content, $uuid, $comment)
    {
        return \App::$db->update(self::table, [
            "lang" => $lang,
            "title" => $title,
            "content" => $content,
            "comment" => $comment,
            "uuid" => $uuid,
            "updatedAt" => time(),
        ], ["id" => $id]);
    }
    public static function get($id)
    {
        return \App::$db->get(self::table, ["id", "lang", "title", "content", "createdAt", "comment", "rendered"], ["id" => $id]);
    }

    public static function render($data)
    {
        $hl = new \Highlight\Highlighter();
        $data["title"] = htmlspecialchars(strlen($data["title"]) ? $data["title"] : "untitled", ENT_QUOTES, 'UTF-8');
        $data["comment"] = htmlspecialchars($data["comment"]);
        $data["createdAt"] = self::humanrizeTime(intval($data["createdAt"]));
        try {
            if ($data["rendered"]) {
                $data["highlighted"] = $data["rendered"];
            } else {
                $highlighted = $hl->highlight($data["lang"], $data["content"]);
                $data["highlighted"] =
                    "<pre><code class=\"hljs {$highlighted->language}\">" . $highlighted->value . "</code></pre>";
                \App::$db->update(self::table, ["rendered" => $data["highlighted"]], ["id" => $data["id"]]);
            }
            // Highlight some code.
        } catch (\DomainException $e) {
            $data["highlighted"] = "highlight not supported.";
        } finally {
            \Flight::render("code.php", $data);
        }
    }

    public static function humanrizeTime($time)
    {
        $rtime = date("Y-m-d H:i", $time);
        $htime = date("H:i", $time);
        $time = time() - $time;
        if ($time < 60) {
            $str = 'just now';
        } elseif ($time < 60 * 60) {
            $min = floor($time / 60);
            $str = $min . ' minute(s) ago';
        } elseif ($time < 60 * 60 * 24) {
            $h = floor($time / (60 * 60));
            $str = $h . ' hour(s) ago ';
        } else {
            $str = $rtime;
        }
        return $str;
    }
    public static function uuidv4()
    {
        $data = random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    public static function langSupport($lang)
    {
        return in_array($lang, [
            "1c",
            "abnf",
            "accesslog",
            "actionscript",
            "ada",
            "angelscript",
            "apache",
            "applescript",
            "arcade",
            "arduino",
            "armasm",
            "asciidoc",
            "aspectj",
            "autohotkey",
            "autoit",
            "avrasm",
            "awk",
            "axapta",
            "bash",
            "basic",
            "bnf",
            "brainfuck",
            "c-like",
            "c",
            "cal",
            "capnproto",
            "ceylon",
            "clean",
            "clojure-repl",
            "clojure",
            "cmake",
            "coffeescript",
            "coq",
            "cos",
            "cpp",
            "crmsh",
            "crystal",
            "csharp",
            "csp",
            "css",
            "d",
            "dart",
            "delphi",
            "diff",
            "django",
            "dns",
            "dockerfile",
            "dos",
            "dsconfig",
            "dts",
            "dust",
            "ebnf",
            "elixir",
            "elm",
            "erb",
            "erlang-repl",
            "erlang",
            "excel",
            "fix",
            "flix",
            "fortran",
            "fsharp",
            "gams",
            "gauss",
            "gcode",
            "gherkin",
            "glsl",
            "gml",
            "go",
            "golo",
            "gradle",
            "groovy",
            "haml",
            "handlebars",
            "haskell",
            "haxe",
            "hsp",
            "html",
            "htmlbars",
            "http",
            "hy",
            "inform7",
            "ini",
            "irpf90",
            "isbl",
            "java",
            "javascript",
            "jboss-cli",
            "json",
            "julia-repl",
            "julia",
            "kotlin",
            "lasso",
            "latex",
            "ldif",
            "leaf",
            "less",
            "lisp",
            "livecodeserver",
            "livescript",
            "llvm",
            "lsl",
            "lua",
            "makefile",
            "markdown",
            "mathematica",
            "matlab",
            "maxima",
            "mel",
            "mercury",
            "mipsasm",
            "mizar",
            "mojolicious",
            "monkey",
            "moonscript",
            "n1ql",
            "nginx",
            "nim",
            "nix",
            "nsis",
            "objectivec",
            "ocaml",
            "openscad",
            "oxygene",
            "parser3",
            "perl",
            "pf",
            "pgsql",
            "php-template",
            "php",
            "plaintext",
            "pony",
            "powershell",
            "processing",
            "profile",
            "prolog",
            "properties",
            "protobuf",
            "puppet",
            "purebasic",
            "python-repl",
            "python",
            "q",
            "qml",
            "r",
            "reasonml",
            "rib",
            "roboconf",
            "routeros",
            "rsl",
            "ruby",
            "ruleslanguage",
            "rust",
            "sas",
            "scala",
            "scheme",
            "scilab",
            "scss",
            "shell",
            "smali",
            "smalltalk",
            "sml",
            "sqf",
            "sql",
            "stan",
            "stata",
            "step21",
            "stylus",
            "subunit",
            "swift",
            "taggerscript",
            "tap",
            "tcl",
            "thrift",
            "tp",
            "twig",
            "typescript",
            "vala",
            "vbnet",
            "vbscript-html",
            "vbscript",
            "verilog",
            "vhdl",
            "vim",
            "x86asm",
            "xl",
            "xml",
            "xquery",
            "yaml",
            "zephir"
        ]);
    }
}
