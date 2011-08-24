#!/usr/bin/python

import sys
import urllib2
#import ConfigParser
import json
from SPARQLWrapper import SPARQLWrapper, JSON

#INPUT = 'dbpedia.ini'
WIKI_SEARCH_URL = 'http://en.wikipedia.org/w/api.php?action=opensearch&search='

def query_wiki(query):
    """Queries Wikipedia API and returns first search result if any"""
    search_url = WIKI_SEARCH_URL + query
    search_url = search_url.replace('"', '')
    
    request = urllib2.Request(search_url)
    request.add_header('User-Agent', 'Mozilla/5.0')
    try:
        results = urllib2.urlopen(request)
    except urllib2.HTTPError, e:
        raise WikipediaError(e.code)
    except urllib2.URLError, e:
        raise WikipediaError(e.reason)
    
    results = results.read()
    # converts string to list
    results = eval(results)
    try:
        result = results[1][0]
        return result.replace(' ', '_')
    except:
        #print "Unexpected error:", sys.exc_info()[0]
        #sys.exit(1)
        return False;
        
    
    
def dbp_res_url(q):
    """Constructs DBPedia resource URL"""
    return '<http://dbpedia.org/resource/'+q+'>'


# reads query input from config file
#config = ConfigParser.ConfigParser()
#config.read(INPUT)
#query = config.get('data', 'query')
#query = 'united+arab+emirates'

# gets query inputs from command line
query = sys.argv[1]
alt_query = sys.argv[2]


#search_url = urllib.quote_plus(search_url)


result = query_wiki(query)
if not result:
    result = query_wiki(alt_query)
# TODO: make python follow wikipedia redirects, eg Arpinum to Arpino

mystring = """
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX geo: <http://www.w3.org/2003/01/geo/wgs84_pos#>
    SELECT *
    WHERE {{
        {0} rdfs:label ?label . 
        {0} <http://dbpedia.org/ontology/abstract> ?abstract .
        {0} geo:lat ?lat .
        {0} geo:long ?long .
        {0} <http://dbpedia.org/ontology/thumbnail> ?thumbnail .
        FILTER (lang(?label) = 'en' && lang(?abstract) = 'en')
    }}
"""
# substitute values into above sparql
mystring = mystring.format(dbp_res_url(result))

# queries DBPedia
sparql = SPARQLWrapper("http://dbpedia.org/sparql")
sparql.setQuery(mystring)
sparql.setReturnFormat(JSON)
resp = sparql.query().convert()

if resp['results']['bindings']:
    print json.dumps(resp['results']['bindings'][0])