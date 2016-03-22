jQuery.fn.extend({
    highlight: function(search, insensitive, highlightClass){
        var regex = new RegExp("(<[^>]*>)|(\\b"+ search.replace(/([-.*+?^${}()|[\]\/\\])/g,"\\$1") +")", insensitive ? "ig" : "g");
        return this.html(this.html().replace(regex, function(a, b, c){
            return (a.charAt(0) == "<") ? a : "<strong class=\""+ highlightClass +"\">" + c + "</strong>";
        }));
    }
});

jQuery(document).ready(function($){
    if(typeof(wallySearchQuery) != 'undefined'){
        $("#search-results .article-box").each(function(i, article) {
            $(article).highlight(wallySearchQuery, 1, "is-highlighted");
        });
    }
});