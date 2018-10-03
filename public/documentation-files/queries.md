### Endpoints - endless possibilities

Instead of specifying a list of endpoints that we think are useful to you. We put the power of MongoDB Query Language - a full-featured query language - at your fingertips. Imagine being able to query an API with sql-like parameters. This is exactly what's happening here, except you will be using queries represented in a JSON-like structure. It gives you endless possibilities for what you can query and build.

MongoDB provides detailed documentation for how to use the MongoDB Query language. The documentation can be found on: [https://docs.mongodb.com/manual/tutorial/query-documents/](https://docs.mongodb.com/manual/tutorial/query-documents/). There are also tons of tutorials, classes, forums and blogs that discuss MongoDB  Query Language.

To get you started, here are some tangible examples:

##### Format
The endpoints are formatted as follow: `endpoint = base_url&q={MongoDB Query}`. To improve readability of the documentation, I'll be sharing the `q` parameter only:

**base_url**:

There are two types of base_url: one that returns the actual json documents and another that returns the count (which is useful for analytics).

To return the count of documents you need to use `count-releases` in the url.
`https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj`

To return the json documents you need to use the `find-releases` in the url.
`https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj`

##### Examples of query parameters:

-----
###### Where a = b
-----

You can build an endpoint in which you return the JSON documents where a field matches a specific value. For example, you could be looking for documents related to a specific buyer, supplier, procurement category, procurement method or status.

Query format: `&q={"fieldname":"fieldvalue"}`

Example query:
- Find documents where status is set to active: `&q={"status":"active"}`  
- Find documents where the buyer.name is "Dinas Kesehatan": `&q={"buyer.name":"Dinas Kesehatan"}`
- Find documents where the budget is "APBD": `&q={"planning.budget.description":"APBD"}`  
- Find documents where the mainProcurementCategory is "services" : `&q={"tender.mainProcurementCategory":"services"}`

Example endpoint:

- **Count** the documents with mainProcurementCategory = "services" by using **count-releases** [https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.mainProcurementCategory":"services"}](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.mainProcurementCategory":"services"})

- **List** the documents with mainProcurementCategory = "services" by using **find-releases** [https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.mainProcurementCategory":"services"}](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.mainProcurementCategory":"services"})

-----
###### Where (a=b) and (b=c)
-----

Query format: `&q={"fieldname1":"fieldvalue1", "fieldname2":"fieldvalue2"}`

Example:
`&q={"buyer.name":"Dinas Kesehatan","planning.budget.description":"APBD" }`

- **Count** the documents with Dinas Kesehatan as a buyer and APBD as a budget by using **count-releases**
[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"buyer.name":"Dinas Kesehatan","planning.budget.description":"APBD"}](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={%22buyer.name%22:%22Dinas%20Kesehatan%22,%22planning.budget.description%22:%22APBD%22})

- **List** the documents with Dinas Kesehatan as a buyer and APBD as a budget by using **find-releases**
[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"buyer.name":"Dinas Kesehatan","planning.budget.description":"APBD"}](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={%22buyer.name%22:%22Dinas%20Kesehatan%22,%22planning.budget.description%22:%22APBD%22})

------
**Where a in (b,c,d)**

Query format: `&q={$in["services", "works"]}`

-----
**Where a > n**

`&q={"tender.value.amount":{"$gt":100000}}``

-----
**Where a < n**

`&q={"tender.value.amount":{"$lt":100000}}`

-----
**Where a not equals n**

Query format: `&q={"fieldname": { "$ne": "fieldvalue"}}`

Example: `&q={"tender.mainProcurementCategory": { $ne: "services"}}`

- **Count** the documents where the mainProcurementCategory is not "services" by using **count-releases**
[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.mainProcurementCategory": { $ne: "services" }}](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={%22tender.mainProcurementCategory%22:%20{%22$ne%22:%20%22services%22}})

- **List** the documents where the mainProcurementCategory is not "services" by using **find-releases**
[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.mainProcurementCategory": { $ne: "services" }}](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={%22tender.mainProcurementCategory%22:%20{%22$ne%22:%20%22services%22}})
