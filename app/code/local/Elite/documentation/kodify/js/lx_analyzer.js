/**
 * Lx : ECMAScript Lexical Analyzer with a lex like API.
 * 
 * License: LGPLv3
 * 
 * @author Chris Corbyn <chris@w3style.co.uk>
 * @version 0.0.0
 */
 
/**
 * References the currently running LxAnalyzer.
 * 
 * @see {@link LxAnalyzer}
 */
var Lx;

/**
 * Default callback routine for LxDefaultRule.
 * 
 * Pre-defined only for optimization.
 * 
 * If overridden, the action invoked by the default rule will be the new
 * action.
 */
var LxDefaultAction = function LxDefaultAction() {
  Lx.Echo();
  return Lx.Text.charCodeAt(0);
};

/**
 * The default matching rule used internally by Lx.
 * 
 * Pre-defined only for optimization.
 * 
 * If overridden any unmatched tokens will be checked by the new rule.
 */
var LxDefaultRule =  {
  
  /** Required property "pattern" specifying what to match */
  pattern : /^[\x00-\xFF]/,
  
  /** Required property "action" specifying the routine to invoke */
  action : LxDefaultAction
  
};

/**
 * An action which does nothing.
 * 
 * Pre-defined for optimization.
 * 
 * If overridden, rules applied will have the new action by default.
 */
var LxEmptyAction = function LxEmptyAction() {
};

/**
 * The entire lexical analyzer class.
 * 
 * This class contains all functionality for scanning.  When running it is
 * also accessible via the global instance Lx.
 * 
 * - Configuration methods are camelCase, starting with a lowercase letter.
 * - Scanning routine methods are CamelCase starting with an uppercase letter.
 * - Scanning properties are CamelCase starting with an uppercase letter.
 * 
 * @constructor
 */
var LxAnalyzer = function LxAnalyzer() {
  
  /** The input stream (String) */
  this.In = '';
  
  /** The output stream (String) */
  this.Out = '';
  
  /** The current start condition (state ID) */
  this.START = 0;
  
  /** The initial start condition (state ID) */
  this.INITIAL = 0;
  
  /** The EOF token ID */
  this.EOF = 0;
  
  /** The matched text during a scan */
  this.Text = '';
  
  /** The matched Text length during a scan */
  this.Leng = 0;
  
  /** The current line number (only if Lx.countLines() is specified) */
  this.LineNo = 1;
  
  /** The value of the matched token */
  this.Lval = {};
  
  /** @private */
  var _TID = 256;
  
  /** @private */
  var _SID = 0;
  
  /** @private */
  var _rules = {
    0 : []
  };
  
  /** @private */
  var _wantsMore = false;
  
  /** @private */
  var _stateStack = [];
  
  /** @private */
  var _minInputSize = 32;
  
  /** @private */
  var self = this;
  
  /** For consistency between actions using Lx and token specification */
  Lx = self;
  
  // -- Public methods
  
  /**
   * FSA optimization setting for minimum input fragment size.
   * 
   * The scanner will first test if a rule matches inside the first s chars
   * of the input source.
   * 
   * Tokens are permitted to be longer (for example long strings), but the
   * first s chars in the token then must fit the pattern.
   * 
   * Default value 32 should work fine, raising it will increase the chance of
   * matching very long tokens at the expense of speed.
   * 
   * If you try to match an entire string with a rule of say,
   * /"[^"]*"/ then matching will fail for long strings (and rightly so). A
   * more optimized (and flexible) way to match such strings is to use state
   * switching.
   * 
   * Lx.rule('"', Lx.INITIAL).performs(function() {
   *   // Opening "
   *   Lx.PushState(Lx.IN_STRING);
   * });
   * 
   * Lx.rule(/[^"]+/, Lx.IN_STRING).performs(function() {
   *   // String content
   * });
   * 
   * Lx.rule('"', Lx.IN_STRING).performs(function() {
   *   // Closing "
   *   Lx.PopState();
   * });
   * 
   * @param {Integer} s
   */
  this.setMinInputSize = function setMinInputSize(s) {
    _minInputSize = s;
  };
  
  /**
   * Defines a new exclusive state, accessible as a property of the currently
   * running analyzer.
   * 
   * Exclusive states differ from inclusive in the tokens they match.  When
   * the analyzer is in an exclusive state it can only match tokens which are
   * in that state.  In an inclusive state the analyzer will match tokens with
   * no specified state along with tokens in its own state.
   * 
   * @param {String} stateName The name of the state (tip: use UPPERCASE)
   * @param {Boolean} exclusive True for an exclusive state, false otherwise
   * 
   * @return The new state ID
   * @type Integer
   */
  this.addExclusiveState = function addState(stateName) {
    if (typeof self[stateName] == "undefined") {
      self[stateName] = ++_SID;
      _rules[_SID] = [];
    }
    return self[stateName];
  };
  
  /**
   * Defines a new token ID with the given name, accessible as a property of
   * the current running analyzer.
   * 
   * Defining a token does nothing by itself.  It must then be returned by
   * the action associated with a rule.
   * 
   * @param {String} tokenName The name of the token (tip: use UPPERCASE)
   * 
   * @return The new token ID
   * @type Integer
   * 
   * @see {@link #addRule}
   */
  this.addToken = function addToken(tokenName) {
    if (typeof self[tokenName] == "undefined") {
      self[tokenName] = ++_TID;
    }
    return self[tokenName];
  };
  
  /**
   * Define a new rule matching the given pattern.
   * 
   * If states is passed as a parameter this rule will only be active when the
   * analyzer is in one of the given states.  The states parameter may be the
   * state ID, or an Array of state IDs.
   * 
   * @param {Object} pattern A String or RegExp to match
   * @param {Object} states The Integer state ID, or an Array of state IDs
   * 
   * @return The new rule (contains a parameter named "action")
   * @type Object
   * 
   * @see {@link #Echo}
   * @see {@link #Begin}
   * @see {@link #PushState}
   * @see {@link #PopState}
   * @see {@link #TopState}
   * @see {@link #Reject}
   * @see {@link #More}
   * @see {@link #Less}
   * @see {@link #Unput}
   * @see {@link #Input}
   * @see {@link #Terminate}
   * 
   * @see {@link #addToken}
   * @see {@link #addState}
   */
  this.addRule = function addRule(pattern, states) {
    if (!states) {
      states = [0];
    }
    
    if (!(states instanceof Array)) {
      states = [states];
    }
    
    var rule = {
      pattern : _optimizePattern(pattern),
      action : LxEmptyAction
    };
    
    var ruleContainer;
    for (var i = 0, len = states.length; i < len; ++i) {
      if (typeof _rules[states[i]] == "undefined") {
        throw "State ID " + states[i] + " does not exist";
      }
      ruleContainer = _rules[states[i]];
      ruleContainer[ruleContainer.length] = rule;
    }
    return rule;
  };
  
  /**
   * Find the next input token, advancing through the input.
   * 
   * If no user-specified token is matched, the character code of the next
   * character is returned instead.
   * 
   * @return The ID of the found token, or 0 (zero) for EOF.
   * @type Integer
   * 
   * @see {@link #wrap}
   * @see {@link #addToken}
   */
  this.lex = function lex() {
    Lx = self;
    
    var tokenId;
    while (!tokenId && self.In.length > 0) {
      tokenId = _lexScan();
    }
    return !tokenId ? self.EOF : tokenId;
  };
  
  /**
   * Returns true if all input has been read, or false if not.
   * 
   * This routine should always be called when {@link #lex} returns 0 since
   * the scanner may want to switch to a new input source.
   * 
   * @return True if finished, false if not.
   * @type Boolean
   */
  this.wrap = function wrap() {
    return self.In.length <= 0;
  };
  
  // -- Scanning routines
  
  /**
   * Tell the analyzer to retain whatever is in the Lx.Text property and append
   * the next found token to it instead of overwriting it.
   * 
   * The value of Lx.Leng must not be modified.
   */
  this.More = function More() {
    _wantsMore = true;
  };
  
  /**
   * Tell the analyzer to put all but the first n characters back into the
   * input stream (Lx.In).
   * 
   * Leng and Text are adjusted accordingly.
   * 
   * @param {Integer} n Number of chars to put back starting at the rightmost
   */
  this.Less = function Less(n) {
    if (n > self.Text.length) {
      throw "Cannot put back " + n + " characters from a " +
        self.Text.length + " token";
    }
    self.In = self.Text.substr(n) + self.In;
    self.Leng = n;
    self.Text = self.Text.substring(0, self.Leng);
  };
  
  /**
   * Place character c at the start of the input stream (Lx.In) so that it will
   * be scanned next.
   * 
   * @param {String} c The character to place back on the input stream
   */
  this.Unput = function Unput(c) {
    self.In = c + self.In;
  };
  
  /**
   * Read the next character in the input stream and seek through the stream.
   * 
   * @return The next character in the input stream
   * @type String
   */
  this.Input = function Input() {
    if (self.In.length == 0) {
      return 0;
    }
    
    var c = self.In.charAt(0);
    self.In = self.In.substring(1);
    return c;
  };
  
  /**
   * Append the contents of Lx.Text to the output stream (Lx.Out).
   */
  this.Echo = function Echo() {
    self.Out += self.Text;
  };
  
  /**
   * Switch the start condition to the given state.
   * 
   * The next time {@link #lex} is invoked it will scan in the new state.
   * 
   * @param {Integer} state The new state ID
   * 
   * @see {@link #addState}
   */
  this.Begin = function Begin(state) {
    if (!(state in _rules)) {
      throw "There is no state ID [" + state + "]";
    }
    self.START = state;
  };
  
  /**
   * Push the current state (Lx.START) onto the state stack and switch to the
   * new state via {@link #Begin}.
   * 
   * @param {Integer} state The new state
   * 
   * @see {@link #addState}
   * @see {@link #PopState}
   * @see {@link #TopState}
   */
  this.PushState = function PushState(state) {
    _stateStack[_stateStack.length] = self.START;
    self.Begin(state);
  };
  
  /**
   * Pops the top off the state stack and switches to it via {@link #Begin}.
   * 
   * @see {@link #addState}
   * @see {@link #PushState}
   * @see {@link #TopState}
   */
  this.PopState = function PopState() {
    self.Begin(self.TopState());
    delete _stateStack[_stateStack.length - 1];
    --_stateStack.length;
  };
  
  /**
   * Returns the current top of the state stack without modifying the stack.
   * 
   * @return The state ID at the top of the state stack, or INITIAL if the
   *         stack is empty.
   * @type Integer
   * 
   * @see {@link #addState}
   * @see {@link #PushState}
   * @see {@link #PopState}
   */
  this.TopState = function TopState() {
    if (_stateStack.length == 0) {
      throw "Cannot read state stack since it is empty";
    }
    return (typeof _stateStack[_stateStack.length - 1] != "undefined")
      ? _stateStack[_stateStack.length - 1]
      : self.INITIAL
      ;
  };
  
  /**
   * Restart with new input, resetting the scanner (except for the START state).
   * 
   * @param {String} input
   */
  this.Restart = function Restart(input) {
    Lx = self;
    self.In = input;
    self.Out = '';
    self.Text = '';
    self.Leng = 0;
    self.LineNo = 1;
    self.Lval = {};
    _wantsMore = false;
    _stateStack = [];
  };
  
  // -- Private methods
  
  /** @private */
  var _optimizePattern = function _optimizePattern(re) {
    if (typeof re.valueOf() == "string") {
      return re.valueOf();
    }
    
    var regexString = re.toString();
    var pattern = regexString.substring(
      regexString.indexOf('/') + 1,
      regexString.lastIndexOf('/')
    );
    var flags = regexString.substring(regexString.lastIndexOf('/') + 1);
    if (!flags) {
      return new RegExp(pattern.replace(/^(?!\^)(.*)/, "^(?:$1)"));
    } else {
      return new RegExp(pattern.replace(/^(?!\^)(.*)/, "^(?:$1)"), flags);
    }
  };
  
  /** @private */
  var _scanByRegExp = function _scanByRegExp(re) {
    var match = '';
    var matches;
    
    //FSA optimization check with re.test()
    if (re.test(self.In.substring(0, _minInputSize))
      && (matches = re.exec(self.In))
      && matches.index == 0) {
      match = matches[0];
    }
    
    return match;
  };
  
  /** @private */
  var _scanByString = function _scanByString(string) {
    var match = '';
    
    if (self.In.substring(0, string.length) == string) {
      match = string;
    }
    
    return match;
  };
  
  /** @private */
  var _lexScan = function _lexScan() {
    var bestLength = 0;
    var bestMatch = '';
    var bestRule;
    
    //Inner function with access to local variables
    var scan = function scan(rule) {
      var match;
      if (typeof rule.pattern != "string") { //TODO: Cheaper test than typeof?
        match = _scanByRegExp(rule.pattern);
      } else /* optimize */ if (bestLength < rule.pattern.length) {
        match = _scanByString(rule.pattern);
      }
      
      if (match && match.length > bestLength) {
        bestLength = match.length;
        bestRule = rule;
        bestMatch = match;
      }
    };
    
    //Test each rule
    for (var i = 0, len = _rules[self.START].length; i < len; ++i) {
      scan(_rules[self.START][i]);
    }
    
    //If none match, use the default rule
    if (!bestRule) {
      scan(LxDefaultRule);
      bestRule = LxDefaultRule;
    }
    
    //Adjust Text and Leng
    if (_wantsMore) {
      self.Text += bestMatch;
      self.Leng += bestMatch.length;
    } else {
      self.Text = bestMatch;
      self.Leng = bestMatch.length;
    }
    
    _wantsMore = false;
    
    self.Lval = bestRule;
    
    //Advanced through the input
    self.In = self.In.substring(bestMatch.length);
    
    //Return whatever the action specifies
    return bestRule.action();
  };
  
};
