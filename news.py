import json

f = open('/tmp/news.json')
news = json.load(f)
f.close()

n = open('/var/www/html/titles.txt', "w")
for i in news['data']['children']:
    n.write(i['data']['title'] + "\n")

n.close()
