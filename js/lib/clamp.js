/*!
* Clamp.js 0.5.1
*
* Copyright 2011-2013, Joseph Schmitt http://joe.sh
* Released under the WTFPL license
* http://sam.zoy.org/wtfpl/
*/

(function(){
    /**
     * Clamps a text node.
     * @param {HTMLElement} element. Element containing the text node to clamp.
     * @param {Object} options. Options to pass to the clamper.
     */
    function clamp(element, options) {
        options = options || {};

        var self = this;
        var win = window;
        var opt = {
                clamp:              options.clamp || 2,
                useNativeClamp:     typeof(options.useNativeClamp) != 'undefined' ? options.useNativeClamp : true,
                truncationChar:     options.truncationChar || '…',
                truncationHTML:     options.truncationHTML,
                nukeElements : options.nukeElements ? true : false
            };
        var sty = element.style;
        var originalText = element.innerHTML;

        var supportsNativeClamp = typeof(element.style.webkitLineClamp) != 'undefined';
        var clampValue = opt.clamp;
        var isCSSValue = clampValue.indexOf && (clampValue.indexOf('px') > -1 || clampValue.indexOf('em') > -1);


// UTILITY FUNCTIONS __________________________________________________________

        /**
         * Return the current style for an element.
         * @param {HTMLElement} elem The element to compute.
         * @param {string} prop The style property.
         * @returns {number}
         */
        function computeStyle(elem, prop) {
            if (!win.getComputedStyle) {
                win.getComputedStyle = function(el, pseudo) {
                    this.el = el;
                    this.getPropertyValue = function(prop) {
                        var re = /(\-([a-z]){1})/g;
                        if (prop == 'float') prop = 'styleFloat';
                        if (re.test(prop)) {
                            prop = prop.replace(re, function () {
                                return arguments[2].toUpperCase();
                            });
                        }
                        return el.currentStyle && el.currentStyle[prop] ? el.currentStyle[prop] : null;
                    }
                    return this;
                }
            }

            return win.getComputedStyle(elem, null).getPropertyValue(prop);
        }

        /**
         * Returns the maximum number of lines of text that should be rendered based
         * on the current height of the element and the line-height of the text.
         */
        function getMaxLines(height) {
            var availHeight = height || element.clientHeight,
                lineHeight = getLineHeight(element);

            return Math.max(Math.floor(availHeight/lineHeight), 0);
        }

        /**
         * Returns the maximum height a given element should have based on the line-
         * height of the text and the given clamp value.
         */
        function getMaxHeight(clmp) {
            var lineHeight = getLineHeight(element);
            return lineHeight * clmp;
        }

        /**
         * Returns the line-height of an element as an integer.
         */
        function getLineHeight(elem) {
            var lh = computeStyle(elem, 'line-height');
            if (lh == 'normal') {
                // Normal line heights vary from browser to browser. The spec recommends
                // a value between 1.0 and 1.2 of the font size. Using 1.1 to split the diff.
                lh = parseInt(computeStyle(elem, 'font-size')) * 1.2;
            }
            return parseInt(lh);
        }


// MEAT AND POTATOES (MMMM, POTATOES...) ______________________________________
        
        /**
         * Traverse down the DOM tree of the targetElem,
         * to find the last (valid) text node. Once found,
         * doTruncateTextNode it. If now the clientHeight < maxHeight, 
         * return "done", up the tree.
         * Else, return one level up, to find the new 
         * options :{
         *  targetElem : element $clamp has been called on
         *  maxHeight : maximum allowed height of targetElem
         *  nukeElements : hide all elements which become the last child node. 
         *  (useful when clamping an article etc with images, lists, more?.)
         *  Also better to use with complicated (even only text) markup.
         * }
         */
        function truncateTextInNode(node,options) {
            //parse options
            if (!node || !options.targetElem || !options.maxHeight){
                return;
            }
            options = options || {nukeElements:false};
            var targetElem=options.targetElem;
            var maxHeight=options.maxHeight;
            var nukeElements=options.nukeElements;

            //Base case : no child nodes
            if(!node.childNodes || node.childNodes.length==0){
                //a non-empty text node, try to truncate it.
                if (node.nodeType==3 && node.textContent && node.textContent.trim()){
                    //truncates till < maxHeight or till ""
                    var remainingText=doTruncateTextNode(node,options);
                    if (targetElem.clientHeight <= maxHeight) {
                        return "done";
                    }
                    else if(targetElem.clientHeight > maxHeight){
                        if (remainingText!=""){
                            throw "doTruncateTextNode returned an invalid value for remainingText."
                        }
                        else{
                            //consumed it completely
                            return "not done";
                        }
                    }
                }
                //an empty text node, skip it
                else if ( node.nodeType==3 && !(node.textContent && node.textContent.trim()) ){
                    return null;
                }
                //an empty element! Skip it
                else if (node.nodeType==1){
                    //Note: this node could be taking up space. 
                    //But this function only truncates text B-)
                    return null;
                }
                //attribute nodes, CDATA nodes, comment nodes etc. Not interested.
                else {
                    return null;
                }
            }
            //Traverse further down, it has child nodes.
            else{
                var numChildren=node.childNodes.length;
                //if it is an element get its last text node
                if (node.nodeType=="1") {
                    for (var i=1;i<=numChildren;i++){
                        var cNode= node.childNodes[numChildren-i];
                        var status=truncateTextInNode(cNode,options);
                        if (status=="done"){
                            return "done";
                        }
                        //otherwise continue truncating text in children
                        if (nukeElements && cNode.nodeType==1){
                            cNode.style.display="none";
                        }
                    }
                    //this element should be empty of any text, so return null
                    return null;
                }
                else{
                    //text nodes don't have children, don't care about other types of nodes
                    return null;
                }
            }
        }
        
        /**
         * Truncates the text in the textNode, till 
         * 1. options.targetElem fits in options.maxHeight or
         * 2. textNode.textContent=="" (i.e. is completely consumed)
         * 
         * textNode : text node whose text to truncate.
         * options :{
         *  targetElem : element $clamp has been called on
         *  maxHeight : maximum allowed height of targetElem
         * }
         *
         * Returns the textNode.textContent (the remaining text)
         * 
         * Method:
         * 
         * Initially uses binary search to find an index to truncate at, so that 
         * targetElem fits. 
         * (The binary search may converge at one character higher, as 
         * a side effect of the discrete jumps in clientHeight with the addition/subtraction of lines.
         * This case will also be taken care of by the second step)
         * 
         * The trivial cases are when the text is entirely consumed, or left untouched. 
         * In the non trivial case, we first add the truncationElement(truncationHTML + truncationChar)
         * Next we remove characters from the end, till targetElem fits. 
         * This also takes care of the side case.
         * If we end up consuming all the text in this second truncation step,
         * we remove the truncation element, and return ""
         * 
         */
        function doTruncateTextNode(textNode, options) {
            //parse options
            if (!options.targetElem || !textNode || !options.maxHeight){
                throw "Missing parameters for doTruncateTextNode";
            }
            var targetElem=options.targetElem;
            var maxHeight=options.maxHeight;
            
            //validate passed node is a text node
            if (textNode.nodeType!=3){
                throw "Passed non text node to doTruncateTextNode";
            }

            var text = textNode.textContent;
            var textLength=text.length;
            
            //binary search and truncate to within
            var low=0;
            var high=textLength;
            var mid=0;
            var iterCount=0;
            const MAX_ITER=20;
            while(low < high-1 && iterCount < MAX_ITER){
                iterCount+=1;
                mid=Math.floor((low+high)/2);
                textNode.textContent=text.substring(0,mid);
                if (targetElem.clientHeight <= maxHeight){
                    low=mid;
                }
                else if (targetElem.clientHeight > maxHeight){
                    high=mid;
                }
                else{
                    break;
                }
            }
            var truncationElem=null;
            //truncated the entire thing
            if (mid==0){
                return "";//==textNode.textContent
            }
            //truncated nothing
            else if (mid==textLength){
                return text;//==textNode.textContent
            }
            //truncated something, add truncation element as last sibling
            else{
                truncationElem=getTruncationElement();
                textNode.parentElement.append(truncationElem);
            }

            //can still add more chars (at most one char?)
            if (targetElem.clientHeight <= maxHeight){
                //should this happen?
                //leave this case for now
            }
            //must truncate more chars
            //may happen, especially on addition of truncation element
            else {
                var end=mid;
                while(targetElem.clientHeight > maxHeight && end > 0){
                    end=end-1;
                    textNode.textContent=text.substring(0,end);
                }
                if (end==0){
                    //what...truncated this completely?
                    //(possible, if the truncation HTML is too big)
                    textNode.parentElement.remove(truncationElem);
                    return "";
                }
                //done
                textNode.textContent=text.substring(0,end);
            }
            //return the final text content
            return textNode.textContent;
        }
        
        function getTruncationElement() {
            var container = document.createElement('div');
            container.style.display="contents";
            //append truncation html
            if (opt.truncationHTML){
                truncationHTMLContainer = document.createElement('span');
                truncationHTMLContainer.innerHTML = opt.truncationHTML;
                container.append(truncationHTMLContainer);
            }
            //append truncation char
            container.append(opt.truncationChar);
            return container;
        }

        function checkResizable(testElem){
            var clone=testElem.cloneNode(true);
            var container = document.createElement('div');
            container.id="#stage";
            container.append(clone);
            testElem.parentElement.append(container);
            var initialHeight = clone.clientHeight;
            // destroy all the content and compare height
            clone.innerHTML="";
            var currentHeight = clone.clientHeight;
            testElem.parentElement.removeChild(container);
            if (initialHeight==0 || currentHeight >= initialHeight) {
                return false;
            }
            else{
                return true;
            }
        }


// CONSTRUCTOR ________________________________________________________________

        if (clampValue == 'auto') {
            clampValue = getMaxLines();
        }
        else if (isCSSValue) {
            clampValue = getMaxLines(parseInt(clampValue));
        }

        var clampedText;
        if (supportsNativeClamp && opt.useNativeClamp) {
            sty.overflow = 'hidden';
            sty.textOverflow = 'ellipsis';
            sty.webkitBoxOrient = 'vertical';
            sty.display = '-webkit-box';
            sty.webkitLineClamp = clampValue;

            if (isCSSValue) {
                sty.height = opt.clamp + 'px';
            }
        }
        else {
            
            if (!checkResizable(element)){
                throw "Uh-oh! Looks like removing the content has no effect on this element's height. You can try setting height:auto";
            }
            var height = getMaxHeight(clampValue);
            if (height <= element.clientHeight) {
                clampedText = truncateTextInNode(element, {targetElem:element,maxHeight:height,
                                        nukeElements:opt.nukeElements});
            }
        }
        
        return {
            'original': originalText,
            'clamped': clampedText
        }
    }

    window.$clamp = clamp;
})();