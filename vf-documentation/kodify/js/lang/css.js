/*
 Kodify Language Specification for CSS.
 */

Kodify.lang("css")

.state("FUNCTION_ARGS")
.state("DIRECTIVE")
.state("VALUE")
.state("PROPERTIES")
.state("DOUBLE_STRING")
.state("SINGLE_STRING")

.rule(/\s\s*/, [Lx.INITIAL, Lx.PROPERTIES, Lx.DIRECTIVE]).onmatch(function() {
  Kodify.unstyled();
})

.rule(/@(?:import|media)/, Lx.INITIAL).onmatch(function() {
  Lx.PushState(Lx.DIRECTIVE);
  Kodify.className("control");
})

.rule(/[\*\+=>]/, Lx.INITIAL).onmatch(function() {
  Kodify.className("operator");
})

.rule(/[\{;]/, Lx.DIRECTIVE).onmatch(function() {
  Lx.PopState();
  if (Lx.Text == '{') {
    Kodify.bracketPair();
  } else {
    Kodify.unstyled();
  }
})

.rule('{', Lx.INITIAL).onmatch(function() {
  Lx.PushState(Lx.PROPERTIES);
  Kodify.bracketPair();
})

.rule(/[\w-][\w-]*/, Lx.PROPERTIES).onmatch(function() {
  Kodify.className("markup attribute");
})

.rule('}', Lx.PROPERTIES).onmatch(function() {
  Lx.PopState();
  Kodify.bracketPair();
})

.rule(':', Lx.PROPERTIES).onmatch(function() {
  Lx.PushState(Lx.VALUE);
  Kodify.unstyled();
})

.rule(';', Lx.VALUE).onmatch(function() {
  Lx.PopState();
  Kodify.unstyled();
})

.rule("!important", Lx.VALUE).onmatch(function() {
  Kodify.className("control");
})

.rule(/\.[\w-][\w-]*/, Lx.INITIAL).onmatch(function() {
  Kodify.className("markup class");
})

.rule(/#[\w-][\w-]*/, Lx.INITIAL).onmatch(function() {
  Kodify.className("markup id");
})

.rule(/[\w-][\w-]*/, Lx.INITIAL).onmatch(function() {
  Kodify.className("markup tag");
})

.rule(/[\w-][\w-]*/, Lx.DIRECTIVE).onmatch(function() {
  var defined = {
    "url" : 1,
    "screen" : 1,
    "print" : 1,
    "all" : 1
  };
  if (Lx.Text.toLowerCase() in defined) {
    Kodify.className("predefined");
  } else {
    Kodify.unstyled();
  }
})

.rule(/\d*(?:\.\d+)?(?:em|px|pt)?/, Lx.VALUE).onmatch(function() {
  Kodify.className("number");
})

.rule(/[\w-][\w-]*/, Lx.VALUE).onmatch(function() {
  var defined = {
    "center" : 1,
    "bold" : 1,
    "italic" : 1,
    "underline" : 1,
    "right" : 1,
    "left" : 1,
    "top" : 1,
    "bottom" : 1,
    "solid" : 1,
    "dashed" : 1,
    "dotted" : 1,
    "normal" : 1,
    "inherit" : 1,
    "auto" : 1,
    "white" : 1,
    "black" : 1,
    "red" : 1,
    "green" : 1,
    "blue" : 1,
    "yellow" : 1,
    "orange" : 1,
    "pink" : 1,
    "violet" : 1,
    "url" : 1,
    "rgb" : 1,
    "repeat-x" : 1,
    "repeat-y" : 1,
    "no-repeat" : 1,
    "repeat" : 1
  };
  if (Lx.Text.toLowerCase() in defined) {
    Kodify.className("predefined");
  } else {
    Kodify.unstyled();
  }
})

.rule(/#[0-9A-Fa-f]+/, Lx.VALUE).onmatch(function() {
  Kodify.className("number hexadecimal");
})

.rule('(', [Lx.INITIAL, Lx.VALUE, Lx.DIRECTIVE]).onmatch(function() {
  Lx.PushState(Lx.FUNCTION_ARGS);
  Kodify.bracketPair();
})

.rule(')', Lx.FUNCTION_ARGS).onmatch(function() {
  Lx.PopState();
  Kodify.bracketPair();
})

.rule(/[\[\]\{\}]/, [Lx.INITIAL, Lx.VALUE, Lx.DIRECTIVE]).onmatch(function() {
  Kodify.bracketPair();
})

.rule("/*", Lx.INITIAL).onmatch(function() {
  Kodify.continueUntil("*/");
  Kodify.className("comment multiline");
})

.rule('"', [Lx.INITIAL, Lx.FUNCTION_ARGS, Lx.DIRECTIVE, Lx.VALUE]).onmatch(function() {
  Kodify.className("string");
  Lx.PushState(Lx.DOUBLE_STRING);
})

.rule(/(?:\\?[^"\n\\]|\\\\|\\")+/, Lx.DOUBLE_STRING).onmatch(function() {
  Kodify.className("string");
})

.rule('"', Lx.DOUBLE_STRING).onmatch(function() {
  Kodify.className("string");
  Lx.PopState();
})

.rule('\'', [Lx.INITIAL, Lx.FUNCTION_ARGS, Lx.FUNCTION_ARGS, Lx.VALUE]).onmatch(function() {
  Kodify.className("string");
  Lx.PushState(Lx.SINGLE_STRING);
})

.rule(/(?:\\?[^'\n\\]|\\\\|\\n)+/, Lx.SINGLE_STRING).onmatch(function() {
  Kodify.className("string");
})

.rule('\'', Lx.SINGLE_STRING).onmatch(function() {
  Kodify.className("string");
  Lx.PopState();
})

.rule(/[\x00-\xFF]/, [Lx.INITIAL, Lx.FUNCTION_ARGS, Lx.VALUE, Lx.PROPERTIES, Lx.DIRECTIVE]).onmatch(function() {
  Kodify.unstyled();
})

;
