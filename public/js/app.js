import { detectLang } from './language-detector.js';

var app = new Vue({
    el: '#app',
    data: {
        message: 'Hello, world!',
        title: '',
        lang: '',
        comment: '',
        mycode: '',
        langs: [
            { text: "纯文本", value: "plaintext" },
            { text: "C", value: "c" },
            { text: "C++", value: "cpp" },
            { text: "C#", value: "cs" },
            { text: "Python", value: "python" },
            { text: "Go", value: "go" },
            { text: "PHP", value: "php" },
            { text: "Markdown", value: "markdown" },
            { text: "Java", value: "java" },
            { text: "JavaScript", value: "javascript" },
            { text: "TypeScript", value: "typescript" },
            { text: "VB.NET", value: "vbnet" },
            { text: "XML", value: "xml" },
            { text: "HTML", value: "html" },
            { text: "Perl", value: "perl" },
            { text: "CSS", value: "css" },
            { text: "YAML", value: "yaml" },
            { text: "JSON / JSON with Comments", value: "json" },
            { text: "Basic", value: "basic" },
            { text: "Dart", value: "dart" },
            { text: "Bash", value: "bash" },
            { text: "Dust", value: "dust" },
            { text: "Rust", value: "rust" },
            { text: "Brainfuck", value: "brainfuck" },
            { text: "CMake", value: "cmake" },
            { text: "CoffeeScript", value: "coffeescript" },
            { text: "CSS", value: "css" },
            { text: "D", value: "d" },
            { text: "Delphi", value: "delphi" },
            { text: "Diff", value: "diff" },
            { text: "Django", value: "django" },
            { text: "DNS Zone file", value: "dns" },
            { text: "Dockerfile", value: "dockerfile" },
            { text: "DOS .bat", value: "dos" },
            { text: "dsconfig", value: "dsconfig" },
            { text: "Device Tree", value: "dts" },
            { text: "Erlang REPL", value: "erlang-repl" },
            { text: "Erlang", value: "erlang" },
            { text: "Fortran", value: "fortran" },
            { text: "F#", value: "fsharp" },
            { text: "GLSL", value: "glsl" },
            { text: "Gradle", value: "gradle" },
            { text: "Groovy", value: "groovy" },
            { text: "Haskell", value: "haskell" },
            { text: "Julia REPL", value: "julia-repl" },
            { text: "Julia", value: "julia" },
            { text: "Kotlin", value: "kotlin" },
            { text: "Less", value: "less" },
            { text: "Lisp", value: "lisp" },
            { text: "LLVM IR", value: "llvm" },
            { text: "LSL (Linden Scripting Language)", value: "lsl" },
            { text: "Lua", value: "lua" },
            { text: "Makefile", value: "makefile" },
            { text: "Mathematica", value: "mathematica" },
            { text: "Matlab", value: "matlab" },
            { text: "MIPS Assembly", value: "mipsasm" },
            { text: "Nginx", value: "nginx" },
            { text: "Objective-C", value: "objectivec" },
            { text: "OCaml", value: "ocaml" },
            { text: "pf.conf", value: "pf" },
            { text: "PostgreSQL SQL dialect and PL/pgSQL", value: "pgsql" },
            { text: "PowerShell", value: "powershell" },
            { text: "Python profile", value: "profile" },
            { text: "Prolog", value: "prolog" },
            { text: "Properties", value: "properties" },
            { text: "PureBASIC", value: "purebasic" },
            { text: "QML", value: "qml" },
            { text: "R", value: "r" },
            { text: "RenderMan RSL", value: "rsl" },
            { text: "Ruby", value: "ruby" },
            { text: "Scala", value: "scala" },
            { text: "Scheme", value: "scheme" },
            { text: "Scilab", value: "scilab" },
            { text: "SCSS", value: "scss" },
            { text: "Shell Session", value: "shell" },
            { text: "SML (Standard ML)", value: "sml" },
            { text: "SQL (Structured Query Language)", value: "sql" },
            { text: "Stylus", value: "stylus" },
            { text: "SubUnit", value: "subunit" },
            { text: "Swift", value: "swift" },
            { text: "TeX", value: "tex" },
            { text: "Thrift", value: "thrift" },
            { text: "Twig", value: "twig" },
            { text: "VBScript in HTML", value: "vbscript-html" },
            { text: "VBScript", value: "vbscript" },
            { text: "Vim Script", value: "vim" },
            { text: "Intel x86 Assembly", value: "x86asm" },
        ]
    },
    watch: {
        mycode: function (val) {
            this.lang = detectLang(val).toLowerCase();

        }
    },
    methods: {
        publish: function (event) {
            axios({
                method: 'post',
                url: '/api/post',
                data: {
                    title: this.title,
                    lang: this.lang,
                    content: this.mycode,
                    comment: this.comment
                }
            }).then((resp) => {
                localStorage.setItem("uuid", resp.data.uuid);
                window.location.href = "/post/" + resp.data.id;
            }).catch((err) => {
                mdtoast(err.response.data.message, { duration: 10000, type: mdtoast.ERROR });
            });
        }
    }
})

