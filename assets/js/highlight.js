//jQuery.fn.extend({
//    highlight: function(search, insensitive, highlightClass){
//        var regex = new RegExp("(<[^>]*>)|(\\b"+ search.replace(/([-.*+?^${}()|[\]\/\\])/g,"\\$1") +")", insensitive ? "ig" : "g");
//        return this.html(this.html().replace(regex, function(a, b, c){
//            console.log(a,b,c);
//            return (a.charAt(0) == "<") ? a : "<strong class=\""+ highlightClass +"\">" + c + "</strong>";
//        }));
//    }
//});


jQuery.fn.highlight = function(pat) {
    function innerHighlight(node, pat) {
        var skip = 0;
        if (node.nodeType == 3) {
            var pos = node.data.toUpperCase().indexOf(pat);
            pos -= (node.data.substr(0, pos).toUpperCase().length - node.data.substr(0, pos).length);
            if (pos >= 0) {
                var spannode = document.createElement('span');
                spannode.className = 'is-highlighted';
                var middlebit = node.splitText(pos);
                var endbit = middlebit.splitText(pat.length);
                var middleclone = middlebit.cloneNode(true);
                spannode.appendChild(middleclone);
                middlebit.parentNode.replaceChild(spannode, middlebit);
                skip = 1;
            }
        }
        else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
            for (var i = 0; i < node.childNodes.length; ++i) {
                i += innerHighlight(node.childNodes[i], pat);
            }
        }
        return skip;
    }
    return this.length && pat && pat.length ? this.each(function() {
        innerHighlight(this, pat.toUpperCase());
    }) : this;
};

jQuery(document).ready(function($){
    if(typeof(wallySearchQuery) != 'undefined'){
        $("#search-results .article-box").each(function(i, article) {
            $(article).highlight(wallySearchQuery);
        });
    }
});