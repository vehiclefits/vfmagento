/*
 Kodify Language Specification for JavaScript.
 */

Kodify.lang("js")

.state("REGEXP")
.state("STRING")
.state("LITERAL")
.state("MULTILINE_COMMENT")

.addflag("regexAllowed", true)

.rule(/\s\s*/, Lx.INITIAL).onmatch(function() {
  Kodify.unstyled();
})

.rule(/[\$a-zA-Z_][\$0-9a-zA-Z_]*/, Lx.INITIAL).onmatch(function() {
  Kodify.flag("regexAllowed", false);
  var keywords = {
    "var" : 1,
    "function" : 1,
    "return" : 1,
    "case" : 1,
    "default" : 1,
    "break" : 1,
    "continue" : 1,
    "throw" : 1,
    "typeof" : 1,
    "delete" : 1,
    "true" : 1,
    "false" : 1,
    "null": 1,
    "NaN" : 1,
    "in" : 1,
    "new" : 1,
    "instanceof" : 1
  };

  var controls = {
    "for" : 1,
    "while" : 1,
    "do" : 1,
    "if" : 1,
    "else" : 1,
    "try" : 1,
    "catch" : 1,
    "switch" : 1
  };

  var objects = {
    "this" : 1,
    "window" : 1,
    "document" : 1,
    "console" : 1,
    "prototype" : 1,
    "constructor" : 1,
    "parent" : 1
  };
  
  if (Lx.Text in keywords) {
    Kodify.className("keyword");
  } else if (Lx.Text in controls) {
    Kodify.className("control");
  } else if (Lx.Text in objects) {
    Kodify.className("predefined identifier");
  } else {
    Kodify.className("identitier");
  }
})

.rule(/\d+(?:\.\d+)?/, Lx.INITIAL).onmatch(function() {
  Kodify.flag("regexAllowed", false);
  Kodify.className("number");
})

.rule(/0x[\dA-Fa-f]+/, Lx.INITIAL).onmatch(function() {
  Kodify.flag("regexAllowed", false);
  Kodify.className("number hexadecimal");
})

.rule(/[\+\-=\/&\^~%\?\*!\|:<>]/, Lx.INITIAL).onmatch(function() {
  if (Lx.Text == '/' && Kodify.flag("regexAllowed")) {
    Kodify.className("regex");
    Lx.PushState(Lx.REGEXP);
    Kodify.flag("regexAllowed", false);
  } else {
    Kodify.className("operator");
    Kodify.flag("regexAllowed", true);
  }
})

.rule(/[\(\{]/, Lx.INITIAL).onmatch(function() {
  Kodify.flag("regexAllowed", true);
  Kodify.bracketPair();
})

.rule(':', Lx.INITIAL).onmatch(function() {
  Kodify.flag("regexAllowed", true);
  Kodify.unstyled();
})

.rule(/[\[\]\}\)]/, Lx.INITIAL).onmatch(function() {
  Kodify.bracketPair();
})

.rule(/(?:\\?[^\/\n\\]|\\\/|\\\\)+/, Lx.REGEXP).onmatch(function() {
  Kodify.className("regex");
})

.rule('/', Lx.REGEXP).onmatch(function() {
  Kodify.className("regex");
  Lx.PopState();
})

.rule('"', Lx.INITIAL).onmatch(function() {
  Kodify.flag("regexAllowed", false);
  Kodify.className("string literal");
  Lx.PushState(Lx.LITERAL);
})

.rule(/(?:\\?[^"\n\\]|\\\\|\\")+/, Lx.LITERAL).onmatch(function() {
  Kodify.className("string literal");
})

.rule('"', Lx.LITERAL).onmatch(function() {
  Kodify.className("string literal");
  Lx.PopState();
})

.rule('\'', Lx.INITIAL).onmatch(function() {
  Kodify.flag("regexAllowed", false);
  Kodify.className("string");
  Lx.PushState(Lx.STRING);
})

.rule(/(?:\\?[^'\n\\]|\\\\|\\')+/, Lx.STRING).onmatch(function() {
  Kodify.className("string");
})

.rule('\'', Lx.STRING).onmatch(function() {
  Kodify.className("string");
  Lx.PopState();
})

.rule("/*", Lx.INITIAL).onmatch(function() {
  Lx.PushState(Lx.MULTILINE_COMMENT);
  Kodify.className("comment multiline");
})

.rule(/(?:[^\*]|(?:\*(?!\/)))+/, Lx.MULTILINE_COMMENT).onmatch(function() {
  Kodify.className("comment multiline");
})

.rule("*/", Lx.MULTILINE_COMMENT).onmatch(function() {
  Kodify.className("comment multiline");
  Lx.PopState();
})

.rule(/(?:\/\/).+/, Lx.INITIAL).onmatch(function() {
  Kodify.flag("regexAllowed", true);
  Kodify.className("comment singleline");
})

.rule(/[\x00-\xFF]/, Lx.INITIAL).onmatch(function() {
  Kodify.unstyled();
})

;
