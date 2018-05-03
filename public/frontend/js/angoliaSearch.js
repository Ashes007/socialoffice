/* Downloaded from https://www.codeseek.co/ */
'use strict';
 
var search = instantsearch({
  appId: 'YSH65GN3MY',
  apiKey: '909af66ddb45355625135f076718476b',
  indexName: 'TAWASUL'
});
 
search.addWidget(instantsearch.widgets.searchBox({
  container: '#search-box',
  placeholder: 'Search for employees',
  autofocus: false
}));
 
search.addWidget(instantsearch.widgets.stats({
  container: '#stats'
}));
 
var hitTemplate = document.getElementById('movie').innerHTML;
 
search.addWidget(instantsearch.widgets.hits({
  container: '#hits',
  hitsPerPage: 300,
  templates: {
    item: hitTemplate
  },
  transformData: function transformData(hit) {
    hit.stars = [];
    for (var i = 1; i <= 5; ++i) {
      hit.stars.push(i <= hit.rating);
    }
    return hit;
  }
}));
 
search.addWidget(instantsearch.widgets.pagination({
  container: '#pagination'
}));
 

 
search.start();

