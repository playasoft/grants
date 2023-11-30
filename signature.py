import http.client

conn = http.client.HTTPSConnection("api.docuseal.co")

headers = { 'X-Auth-Token': "JQhcNFzhao6Pq7YKkJjcom" }

conn.request("GET", "/templates", headers=headers)

res = conn.getresponse()
data = res.read()

print(data.decode("utf-8"))