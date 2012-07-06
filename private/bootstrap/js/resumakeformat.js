CodeMirror.defineMode("clike", function(config, parserConfig) {
  var indentUnit = config.indentUnit,
      keywords = parserConfig.keywords || {},
      blockKeywords = parserConfig.blockKeywords || {},
      atoms = parserConfig.atoms || {},
      hooks = parserConfig.hooks || {},
      multiLineStrings = parserConfig.multiLineStrings;
  var isOperatorChar = /[]/;

  var curPunc;

  function tokenBase(stream, state) {
    var ch = stream.next();
    if (ch == "#") {
		var isComment = true;
	  for(var i = 0; i < 34; i++){
	    if(!stream.eat("#"))
		  isComment = false;
	  }
      if (isComment) {
        state.tokenize = tokenComment;
        return tokenComment(stream, state);
      }
    }
    stream.eatWhile(/[:-\w\$_]/);
    var cur = stream.current();
    if (keywords.propertyIsEnumerable(cur)) {
      if (blockKeywords.propertyIsEnumerable(cur)) curPunc = "newstatement";
      return "keyword";
    }
    if (atoms.propertyIsEnumerable(cur)) return "atom";
    return "word";
  }

  function tokenString(quote) {
    return function(stream, state) {
      var escaped = false, next, end = false;
      while ((next = stream.next()) != null) {
        if (next == quote && !escaped) {end = true; break;}
        escaped = !escaped && next == "\\";
      }
      if (end || !(escaped || multiLineStrings))
        state.tokenize = tokenBase;
      return "string";
    };
  }

  function tokenComment(stream, state) {
    var maybeEnd = false, ch;
	var count = 0;
    while (ch = stream.next()) {
      if (count == 34) {
        state.tokenize = tokenBase;
        break;
      }
      if(ch == "#"){
	  count++;
	  }
	  else count = 0;
    }
    return "comment";
  }

  function Context(indented, column, type, align, prev) {
    this.indented = indented;
    this.column = column;
    this.type = type;
    this.align = align;
    this.prev = prev;
  }
  function pushContext(state, col, type) {
    return state.context = new Context(state.indented, col, type, null, state.context);
  }

  // Interface

  return {
    startState: function(basecolumn) {
      return {
        tokenize: null,
        context: new Context((basecolumn || 0) - indentUnit, 0, "top", false),
        indented: 0,
        startOfLine: true
      };
    },

    token: function(stream, state) {
      var ctx = state.context;
      if (stream.sol()) {
        if (ctx.align == null) ctx.align = false;
        state.indented = stream.indentation();
        state.startOfLine = true;
      }
      if (stream.eatSpace()) return null;
      curPunc = null;
      var style = (state.tokenize || tokenBase)(stream, state);
      if (style == "comment" || style == "meta") return style;
      if (ctx.align == null) ctx.align = true;

      state.startOfLine = false;
      return style;
    },

    indent: function(state, textAfter) {
      if (state.tokenize != tokenBase && state.tokenize != null) return 0;
      var ctx = state.context, firstChar = textAfter && textAfter.charAt(0);
      if (ctx.type == "statement" && firstChar == "}") ctx = ctx.prev;
      var closing = firstChar == ctx.type;
      if (ctx.type == "statement") return ctx.indented + (firstChar == "{" ? 0 : indentUnit);
      else if (ctx.align) return ctx.column + (closing ? 0 : 1);
      else return ctx.indented + (closing ? 0 : indentUnit);
    },

    electricChars: ""
  };
});

(function() {
  function words(str) {
    var obj = {}, words = str.split(" ");
    for (var i = 0; i < words.length; ++i) obj[words[i]] = true;
    return obj;
  }
  
  CodeMirror.defineMIME("text/x-java", {
    name: "clike",
    keywords: words(""),
    blockKeywords: words(""),
    atoms: words("Name: Position: Statement: Address: City: State: Zip: Phone-Number: Email: School: Degree: Start-Date: End-Date: Award: Skill-Category: Skill-Name: Skill-Description: Experience-Title: Experience-Start-Date: Experience-End-Date: Experience-Group: Experience-Fact: Experience-Link-Name: Experience-Link: Activity-Title: Activity-Start-Date: Activity-End-Date: Activity-Fact: Activity-Link-Name: Activity-Link:"),
    hooks: {
      "@": function(stream, state) {
        stream.eatWhile(/[:-\w\$_]/);
        return "meta";
      }
    }
  });
}());
