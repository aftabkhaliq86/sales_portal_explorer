<html><head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title></title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/result-light.css">


  <style id="compiled-css" type="text/css">
      
    /* EOS */
  </style>

  <script id="insert"></script>


    <script src="/js/stringify.js?80e56a799f97c7863ef2aa2731fedafae31dd3fa" charset="utf-8"></script>
    <script>
      const customConsole = (w) => {
        const pushToConsole = (payload, type) => {
          w.parent.postMessage({
            console: {
              payload: stringify(payload),
              type:    type
            }
          }, "*")
        }

        w.onerror = (message, url, line, column) => {
          // the line needs to correspond with the editor panel
          // unfortunately this number needs to be altered every time this view is changed
          line = line - 70
          if (line < 0){
            pushToConsole(message, "error")
          } else {
            pushToConsole(`[${line}:${column}] ${message}`, "error")
          }
        }

        let console = (function(systemConsole){
          return {
            log: function(){
              let args = Array.from(arguments)
              pushToConsole(args, "log")
              systemConsole.log.apply(this, args)
            },
            info: function(){
              let args = Array.from(arguments)
              pushToConsole(args, "info")
              systemConsole.info.apply(this, args)
            },
            warn: function(){
              let args = Array.from(arguments)
              pushToConsole(args, "warn")
              systemConsole.warn.apply(this, args)
            },
            error: function(){
              let args = Array.from(arguments)
              pushToConsole(args, "error")
              systemConsole.error.apply(this, args)
            },
            system: function(arg){
              pushToConsole(arg, "system")
            },
            clear: function(){
              systemConsole.clear.apply(this, {})
            },
            time: function(){
              let args = Array.from(arguments)
              systemConsole.time.apply(this, args)
            },
            assert: function(assertion, label){
              if (!assertion){
                pushToConsole(label, "log")
              }

              let args = Array.from(arguments)
              systemConsole.assert.apply(this, args)
            }
          }
        }(window.console))

        window.console = { ...window.console, ...console }

        console.system("Running fiddle")
      }

      if (window.parent){
        customConsole(window)
      }
    </script>
</head>
<body>
    <selecthttps: jsfiddle.net="" tth4x2o9="" #fork="" id="package">
  <option value="Package A">Package A</option>
  <option value="Package B">Package B</option>


<input type="text" id="the_total" name="total">
<input type="text" id="price" name="price">

    <script type="text/javascript">//<![CDATA[


$(function(){
	function doTotal(){
		  var the_total = $("#the_total").val();
          var get_package = $("#package").val();
          var total = 0;
          get_package == 'Package A'?total = the_total * 100:total = the_total * 200;
          $("#price").val(total);
	}
    $('#the_total').keyup(function() {
    	doTotal();
    });
    
    $('#package').change(function(){
    	doTotal();
    });
});


  //]]></script>

  <script>
    // tell the embed parent frame the height of the content
    if (window.parent && window.parent.parent){
      window.parent.parent.postMessage(["resultsFrame", {
        height: document.body.getBoundingClientRect().height,
        slug: "tth4x2o9"
      }], "*")
    }

    // always overwrite window.name, in case users try to set it manually
    window.name = "result"
  </script>

    <script>
      let allLines = []

      window.addEventListener("message", (message) => {
        if (message.data.console){
          let insert = document.querySelector("#insert")
          allLines.push(message.data.console.payload)
          insert.innerHTML = allLines.join(";\r")

          let result = eval.call(null, message.data.console.payload)
          if (result !== undefined){
            console.log(result)
          }
        }
      })
    </script>



</selecthttps:><pre id="_h#2" style="white-space: pre-wrap; position: absolute; z-index: -9; visibility: hidden; display: block; font-family: Arial; font-size: 13.3333px; font-weight: 400; font-style: normal; text-transform: none; text-decoration: none solid rgb(0, 0, 0); letter-spacing: normal; word-spacing: 0px; line-height: normal; text-align: start; vertical-align: baseline; direction: ltr; width: 169px; height: 15px; margin: 0px; padding: 1px 2px; border-width: 2px; border-style: inset; overflow: auto; left: 8px; top: 48.375px;"><span>&ZeroWidthSpace;</span> </pre></body></html>