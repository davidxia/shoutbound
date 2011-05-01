#!/usr/bin/python

import sys
import urllib2
import ConfigParser
import json
from SPARQLWrapper import SPARQLWrapper, JSON

INPUT = 'dbpedia.ini'

# function that queries Wikipedia API
def query_wiki(url):
    request = urllib2.Request(url)
    request.add_header('User-Agent', 'Mozilla/5.0')
    try:
        result = urllib2.urlopen(request)
    except urllib2.HTTPError, e:
        raise WikipediaError(e.code)
    except urllib2.URLError, e:
        raise WikipediaError(e.reason)
           
    return result
    
def dbp_res_url(q):
    return '<http://dbpedia.org/resource/'+q+'>'

# gets query input from input file
config = ConfigParser.ConfigParser()
config.read(INPUT)
#query = config.get('data', 'query')
#query = 'united+arab+emirates'
query = sys.argv[1]

url_search = 'http://en.wikipedia.org/w/api.php?action=opensearch&search=' + query
url_search = url_search.replace('"', '')
#url_search = urllib.quote_plus(url_search)


# queries Wikipedia API and returns search results
results = query_wiki(url_search).read()
# converts string to list
results = eval(results)
# returns first search result if exists
try:
    result = results[1][0]
except:
    #print "Unexpected error:", sys.exc_info()[0]
    sys.exit(1)

# TODO: make python follow wikipedia redirects, eg Arpinum to Arpino
    
result = result.replace(' ', '_')


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


print json.dumps(resp['results']['bindings'][0])