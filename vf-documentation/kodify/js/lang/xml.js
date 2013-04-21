/*
 Kodify Language Specification for XML.
 */

Kodify.lang("xml")

.state("XML_HEADER")
.state("DOCTYPE")
.state("TAG")
.state("DOUBLE_STRING")
.state("SINGLE_STRING")
.state("CDATA")

.addflag("tagNameFound", false)

.rule(/\s\s*/, [Lx.INITIAL, Lx.XML_HEADER, Lx.TAG, Lx.DOCTYPE]).onmatch(function() {
  Kodify.unstyled();
})

.rule('<?xml', Lx.INITIAL).onmatch(function() {
  Kodify.className("markup xml");
  Lx.PushState(Lx.XML_HEADER);
})

.rule('?>', Lx.XML_HEADER).onmatch(function() {
  Kodify.className("markup xml");
  Lx.PopState();
})

.rule('<!DOCTYPE', Lx.INITIAL).onmatch(function() {
  Kodify.className("markup doctype");
  Lx.PushState(Lx.DOCTYPE);
})

.rule('>', Lx.DOCTYPE).onmatch(function() {
  Kodify.className("markup doctype");
  Lx.PopState();
})

.rule(/\w[:\w]*/, Lx.TAG).onmatch(function() {
  if (!Kodify.flag("tagNameFound")) {
    Kodify.flag("tagNameFound", true);
    Kodify.className("markup tag");
  } else {
    Kodify.className("markup attribute");
  }
})

.rule(/\w[:\w]*/, [Lx.XML_HEADER, Lx.DOCTYPE]).onmatch(function() {
  Kodify.className("markup attribute");
})

.rule('=', [Lx.TAG, Lx.XML_HEADER, Lx.DOCTYPE]).onmatch(function() {
  Kodify.className("operator");
})

.rule('<', Lx.INITIAL).onmatch(function() {
  Kodify.flag("tagNameFound", false);
  Kodify.unstyled();
  Lx.PushState(Lx.TAG);
})

.rule('>', Lx.TAG).onmatch(function() {
  Kodify.unstyled();
  Lx.PopState();
})

.rule('"', [Lx.TAG, Lx.XML_HEADER, Lx.DOCTYPE]).onmatch(function() {
  Kodify.className("string");
  Lx.PushState(Lx.DOUBLE_STRING);
})

.rule(/[^"]+/, Lx.DOUBLE_STRING).onmatch(function() {
  Kodify.className("string");
})

.rule('"', Lx.DOUBLE_STRING).onmatch(function() {
  Kodify.className("string");
  Lx.PopState();
})

.rule('\'', [Lx.TAG, Lx.XML_HEADER, Lx.DOCTYPE]).onmatch(function() {
  Kodify.className("string");
  Lx.PushState(Lx.SINGLE_STRING);
})

.rule(/[^']+/, Lx.SINGLE_STRING).onmatch(function() {
  Kodify.className("string");
})

.rule('\'', Lx.SINGLE_STRING).onmatch(function() {
  Kodify.className("string");
  Lx.PopState();
})

.rule("<!--", Lx.INITIAL).onmatch(function() {
  Kodify.continueUntil("-->");
  Kodify.className("comment");
})

.rule(/[\x00-\xFF]/, [Lx.INITIAL, Lx.TAG, Lx.XML_HEADER, Lx.DOCTYPE]).onmatch(function() {
  Kodify.unstyled();
})

;
