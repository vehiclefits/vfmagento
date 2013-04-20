/**
 * Kodify : JavaScript Code Beautifier using a real lexical scanning approach.
 * 
 * License: LGPLv3
 * 
 * @author Chris Corbyn <chris@w3style.co.uk>
 * @version 0.0.0
 */

/** Config setting for the class needed for kodify to operate */
var KodifyClassName = "kodify";

/**
 * The default before() routine.
 * 
 * @see {@link KodifyLanguage#before}
 */
var KodifyPreprocess = function(){};
 
/**
 * A programming language specification, wrapping the "Lx" project.
 * 
 * @constructor
 * 
 * @param {String} name The name of the language
 * 
 * @see {@link Kodify#lang}
 */
var KodifyLanguage = function KodifyLanguage(name) {
  
  /** The name of this language */
  this.name = name;
  
  /** @private */
  var _before = KodifyPreprocess;
  
  /** @private */
  var _scanner = new LxAnalyzer();
  
  /** @private */
  var _currentRule;
  
  /** @private */
  var _flags = {};
  
  /** @private */
  var self = this;
  
  /**
   * Specify a callback procedure to run before the full scan.
   * 
   * This can be used to set an initial state dynamically based on Lx.In.
   * 
   * @param {Function} callback
   * @return The current instance for method chaining
   */
  this.before = function before(callback) {
    _before = callback;
    return self;
  };
  
  /**
   * Declare a new flag named flagName having value v.
   * 
   * @param {String} flagName The name of the flag
   * @param {Object} v The value to set
   * @return The current instance for method chaining
   * 
   * @see {@link #flag}
   */
  this.addflag = function addflag(flagName, v) {
    _flags[flagName] = v;
    return self;
  };
  
  /**
   * Check the value of a flag named flagName, or change it's value to v.
   * 
   * If the second parameter v is passed the value of the flag is changed to v.
   * 
   * @param {String} flagName The name of the flag
   * @param {Object} v An optional value to set
   * @return The value of the flag named flagName
   * 
   * @see {@link addflag}
   */
  this.flag = function flag(flagName, v) {
    if (typeof v != "undefined") {
      _flags[flagName] = v;
    }
    return _flags[flagName];
  };
  
  /**
   * Declare a named state in the lexical analyzer.
   * 
   * @param {String} s The name of the state
   * @return The current instance for method chaining
   * 
   * @see {@link LxAnalyzer#state}
   */
  this.state = function state(s) {
    _scanner.addExclusiveState(s);
    return self;
  };
  
  /**
   * Create a new rule in the lexical analyzer.
   * 
   * @param {Object} pattern A RegExp or a String
   * @param {Object} states A state ID or an Array of state IDs
   * @return The current instance for method chaining
   * 
   * @see {@link LxAnalyzer#rule}
   */
  this.rule = function rule(pattern, states) {
    _currentRule = _scanner.addRule(pattern, states);
    return self
  };
  
  /**
   * Specify the action to run when the last declared rule is matched.
   * 
   * @param {Function} callback
   * 
   * @see {@link LxAnalyzer#rule}
   */
  this.onmatch = function onmatch(callback) {
    _currentRule.action = callback;
    return self;
  };
  
  /**
   * Replace the contents of "element" with the beautified version.
   * 
   * @param {Element} element An element from the DOM
   */
  this.beautify = function beautify(element) {
    var originalFlags = _flags;
    
    Kodify.language = self;
    Kodify.scanner = _scanner;
    Kodify.builder = new KodifyBuilder(element);
    
    //This following trick preserves white-space in innerText in IE
    var cloned = element.cloneNode(true);
    var pre = document.createElement("pre");
    pre.appendChild(cloned);
    var textContent = pre.textContent
      ? pre.textContent
      : pre.innerText;
    delete pre;
    delete cloned;
    
    _scanner.Begin(_scanner.INITIAL);
    _scanner.Restart(textContent);
    _before();
    while ((0 != _scanner.lex())) ;
    
    _flags = originalFlags;
    
    Kodify.builder.commit();
  };
  
};

/**
 * The Builder class for managing the creation of beautified content.
 * 
 * @constructor
 * 
 * @param {Element} element The target element to write to
 */
var KodifyBuilder = function KodifyBuilder(element) {
  
  /** @private */
  var _target = element;
  
  /** @private */
  var _context = document.createElement("span");
  
  /** @private */
  var self = this;
  
  /**
   * Append a node to the current context, applying className to it.
   * 
   * @param {String} text The text to append
   * @param {String} className The class name to apply to the text
   * @param {String} id The ID of the token in the DOM
   * @param {Object} eventListeners As an object map where { type : callback }
   */
  this.append = function append(text, className, id, eventListeners) {
    eventListeners = eventListeners || {};
    var s = document.createElement("span");
    if (className) {
      s.className = className;
    }
    if (id) {
      s.id = id;
    }
    var t = document.createTextNode(text);
    s.appendChild(t);
    
    for (var type in eventListeners) {
      s["on" + type] = eventListeners[type];
    }
    
    _context.appendChild(s);
  };
  
  /**
   * Commit changes to the target element.
   */
  this.commit = function commit() {
    _target.innerHTML = '';
    _target.appendChild(_context);
  };
  
};

/**
 * Handles the pairing of brackets in source code.
 */
var KodifyBracketManager = new (function KodifyBracketManager() {
  
  /** @private */
  var _pairs = {
    '{' : '}',
    '}' : '{',
    '[' : ']',
    ']' : '[',
    '(' : ')',
    ')' : '(',
    '<' : '>',
    '>' : '<'
  };
  
  /** @private */
  var _stack = {
    '{' : [],
    '[' : [],
    '(' : [],
    '<' : []
  };
  
  /** @private */
  var _counts = {
    '{' : 0,
    '[' : 0,
    '(' : 0,
    '<' : 0
  };
  
  /** @private */
  var _names = {
    "{" : "kodify_open_curly",
    "}" : "kodify_close_curly",
    "[" : "kodify_open_bracket",
    "]" : "kodify_close_bracket",
    "(" : "kodify_open_paren",
    ")" : "kodify_close_paren",
    "<" : "kodify_open_angle",
    ">" : "kodify_close_angle"
  };
  
  /** @private */
  var self = this;
  
  /**
   * Get the sequence ID for this bracket.
   * 
   * @param {String} c The bracket character
   * @return The sequence ID
   */
  this.sequenceOf = function sequenceOf(c) {
    if (c in _stack) {
      return _stackPush(c);
    } else if (c in _pairs) {
      return _stackPop(_pairs[c]);
    }
  };
  
  /**
   * Get the name associated with this bracket.
   * 
   * @param {String} c The bracket character
   * @return A name describing the bracket
   */
  this.nameOf = function nameOf(c) {
    return _names[c];
  };
  
  /**
   * Event handler for bracket pairing (on state).
   */
  this.revealPair = function revealPair(e) {
    var matchingToken = document.getElementById(_getMatchingId(this.id));
    if (matchingToken) {
      this.className += " bracketpair";
      matchingToken.className += " bracketpair";
    } else {
      this.className += " bracketpair unpaired";
    }
  };
  
  /**
   * Event handler for bracket pairing (off state).
   */
  this.hidePair = function hidePair(e) {
    var matchingToken = document.getElementById(_getMatchingId(this.id));
    this.className = this.className.replace(/\b(?:bracketpair|unpaired)\b/g, '');
    if (matchingToken) {
      matchingToken.className = matchingToken.className.replace(/\b(?:bracketpair|unpaired)\b/g, '');
    }
  };
  
  /** @private */
  var _getMatchingId = function _getMatchingId(id) {
    for (var bracket in _names) {
      if (id.substr(0, _names[bracket].length) == _names[bracket]) {
        return id.replace(
          new RegExp("^" + _names[bracket]), _names[_getOpposite(bracket)]
        );
      }
    }
  };
  
  /** @private */
  var _getOpposite = function _getOpposite(c) {
    for (var left in _pairs) {
      if (c == left) {
        return _pairs[c];
      } else if (c == _pairs[left]) {
        return left;
      }
    }
  };
  
  /** @private */
  var _stackPush = function _stackPush(c) {
    if (c in _stack) {
      _stack[c][_stack[c].length] = ++_counts[c];
      return _counts[c];
    } else {
      throw "Only opening brackets can be pushed onto the stack '" + c + "'";
    }
  };
  
  /** @private */
  var _stackPop = function _stackPop(c) {
    if (_stack[c].length == 0) {
      return;
    }
    
    var count = _stack[c][_stack[c].length -1];
    delete _stack[c][_stack[c].length -1];
    --_stack[c].length;
    return count;
  };
  
});

/**
 * The globally accessible Kodify instance.
 * 
 * A singleton re-used for each block of code to be beautified.
 */
var Kodify = {
  
  /** The {@link KodifyBuilder} instance */
  builder : {},
  
  scanner : {},
  
  /** The currently scanning {@link KodifyLanguage} instance */
  language : {},
  
  /** Loaded language specifications as {@link KodifyLanguage} objects */
  languageList : {},
  
  defaultLanguage : (new KodifyLanguage("code"))
    .state("SINGLE_STRING")
    .state("DOUBLE_STRING")
    .state("MULTILINE_COMMENT")
    .rule(/\s\s*/, Lx.INITIAL).onmatch(function() {
      Kodify.unstyled();
    })
    .rule(/[\$a-zA-Z_][\$0-9a-zA-Z_]*/, Lx.INITIAL).onmatch(function() {
      var keywords = {
        "var" : 1,
        "function" : 1,
        "return" : 1,
        "break" : 1,
        "continue" : 1,
        "throw" : 1,
        "true" : 1,
        "false" : 1,
        "null": 1,
        "new" : 1,
        "instanceof" : 1,
        "class" : 1,
        "interface" : 1,
        "extends" : 1,
        "implements" : 1,
        "abstract" : 1,
        "final" : 1,
        "public" : 1,
        "private" : 1,
        "protected" : 1,
        "static" : 1
      };

      var controls = {
        "for" : 1,
        "while" : 1,
        "do" : 1,
        "if" : 1,
        "else" : 1,
        "try" : 1,
        "catch" : 1
      };

      if (Lx.Text in keywords) {
        Kodify.className("keyword");
      } else if (Lx.Text in controls) {
        Kodify.className("control");
      } else {
        Kodify.className("identitier");
      }
    })
    .rule(/\d+(?:\.\d+)?/, Lx.INITIAL).onmatch(function() {
      Kodify.className("number");
    })
    .rule(/0x[\dA-Fa-f]+/, Lx.INITIAL).onmatch(function() {
      Kodify.className("number hexadecimal");
    })
    .rule(/[\+\-=\/&\^~%\?\*!\|:<>]/, Lx.INITIAL).onmatch(function() {
      Kodify.className("operator");
    })
    .rule('"', Lx.INITIAL).onmatch(function() {
      Kodify.className("string");
      Lx.PushState(Lx.DOUBLE_STRING);
    })
    .rule(/(?:\\?[^"\\]|\\\\|\\")+/, Lx.DOUBLE_STRING).onmatch(function() {
      Kodify.className("string");
    })
    .rule('"', Lx.DOUBLE_STRING).onmatch(function() {
      Kodify.className("string");
      Lx.PopState();
    })
    .rule('\'', Lx.INITIAL).onmatch(function() {
      Kodify.className("string");
      Lx.PushState(Lx.SINGLE_STRING);
    })
    .rule(/(?:\\?[^'\\]|\\\\|\\')+/, Lx.SINGLE_STRING).onmatch(function() {
      Kodify.className("string");
    })
    .rule('\'', Lx.SINGLE_STRING).onmatch(function() {
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
    .rule(/(?:\/\/|#).+/, Lx.INITIAL).onmatch(function() {
      Kodify.className("comment singleline");
    })
    .rule(/[\x00-\xFF]/, Lx.INITIAL).onmatch(function() {
      Kodify.unstyled();
    })
    ,
  
  
  /**
   * Define a new language and return the specification builder.
   * 
   * @param {String} langName The name of the language
   * @return An instance of {@link KodifyLanguage}
   */
  lang : function lang(langName) {
    if (!("langName" in this.languageList)) {
      this.languageList[langName] = new KodifyLanguage(langName);
    }
    return this.languageList[langName];
  },
  
  /**
   * Get or set a flag used in the scanning process.
   * 
   * If the second parameter v is passed the value is changed to v.
   * 
   * @param {String} flagName The name of the flag
   * @param {Object} v A value to set
   * @return The value of the flag named flagName
   * 
   * @see {@link KodifyLanguage#flag}
   */
  flag : function flag(flagName, v) {
    return this.language.flag(flagName, v);
  },
  
  /**
   * Apply the class name "cls" to the matched text during scanning.
   * 
   * @param {String} cls The class name to apply
   */
  className : function className(cls) {
    this.builder.append(this.scanner.Text, cls);
  },
  
  /**
   * Show matching brace pairs on hover.
   * 
   * @param {String} cls Class name to apply to the token
   */
  bracketPair : function bracketPair(cls) {
    var count = KodifyBracketManager.sequenceOf(this.scanner.Text);
    var name = KodifyBracketManager.nameOf(this.scanner.Text);
    
    this.builder.append(this.scanner.Text, cls, name + count,
      {
        "mouseover" : KodifyBracketManager.revealPair,
        "mouseout" : KodifyBracketManager.hidePair
      }
    );
  },
  
  /**
   * Pass the matched text to the builder without applying any class.
   */
  unstyled : function unstyled() {
    this.builder.append(this.scanner.Text);
  },
  
  /**
   * Keep reading input until end is found.
   * 
   * The end marker will be retained in {@link LxAnalyzer.Text}.
   * 
   * @param {String} end The end marker string
   */
  continueUntil : function continueUntil(end) {
    var c;
    do {
      if (0 === (c = Lx.Input())) {
        break;
      }
      Lx.Text += c;
      ++Lx.Leng;
    }
    while (end != Lx.Text.substring(Lx.Text.length - end.length));
  },
  
  /**
   * Beautify all code blocks on the current page.
   * 
   * Anything that has the class name of "kodify" will be scanned.
   */
  beautify : function beautify() {
    var targets = this.getElementsByClassName(KodifyClassName);
    for (var i = 0, ilen = targets.length; i < ilen; ++i) {
      var beautified = false;
      var classParts = targets[i].className.split(/\s+/);
      for (var j = 0, jlen = classParts.length; j < jlen; ++j) {
        if (classParts[j] in this.languageList) {
          this.languageList[classParts[j]].beautify(targets[i]);
          beautified = true;
          break;
        }
      }
      if (!beautified) {
        this.defaultLanguage.beautify(targets[i]);
      }
    }
  },
  
  /**
   * A document.getElementsByClassName() wrapper for non-supporting browsers.
   * 
   * @param {String} className The required class name on the element
   * @return The list of matched Elements
   */
  getElementsByClassName : function getElementsByClasName(className) {
    if (document.getElementsByClassName) {
      return document.getElementsByClassName(className);
    }
    
    //For Internet Explorer 6
    var everything = document.all;
    var elements = [];
    var re = new RegExp("\\b" + className + "\\b", "i");
    for (var i = 0, len = everything.length; i < len; ++i) {
      if (everything[i].className && everything[i].className.match(re)) {
        elements[elements.length] = everything[i];
      }
    }
    return elements;
  }
  
};

//Make sure kodify runs when the page is loaded
// TODO: Stop using window.onload directly... use addEvent() and co.
window.onload = function () {
  Kodify.beautify();
};
