## Basic and advanced API queries

The base URL of Bandung City’s OCDS API is: https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/.

The secret key to access the API is: `6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj`.

The main queries supported by the API are the following:

-   `get-by-ocid`: get specific releases by OCID;
-   `find-releases`: get all releases that meet a certain condition;
-   `count-releases`: count the number of releases that meet a certain condition.

#### The queries use the following format:

https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/get-by-ocid?secret=[secret]&ocid=[ocid]

**_Example:_**

###### Gets the release with the OCID `ocds-afzrfb-s-2016-5043143`

https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/get-by-ocid?secret=[secret]&ocid=ocds-afzrfb-s-2016-5043143

## **Basic queries**

#### **Find releases**

The following URL will search the database for all releases and optionally filter them by the given query using the `q` parameter. It can also limit the number of results returned by the use of the `limit` parameter, with a default value of 20. Pagination is provided using the last MongoDB document with `_id`  displayed, using `fromId` parameter. This is an efficient results pagination method described in detail here (approach 2): [https://www.codementor.io/arpitbhayani/fast-and-efficient-pagination-in-mongodb-9095flbqr](https://www.codementor.io/arpitbhayani/fast-and-efficient-pagination-in-mongodb-9095flbqr).

The query syntax of the `q` parameter follows the MongoDB query syntax: [https://docs.mongodb.com/manual/tutorial/query-documents/](https://docs.mongodb.com/manual/tutorial/query-documents/).

**_Examples:_**

###### Get all releases in the system, paginated using the default 20 items per page:

https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=[secret]

###### Get all releases in the system, paginated using 100 items per page:

https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=[secret]&limit=100

###### Get the releases in the system that have non-empty `tender.value.amount`  property and limit results to 50 per page:

https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=[secret]&q={"tender.value.amount":{"$exists":true}}&limit=50

###### Get the releases in the system that have non-empty `tender.value.amount`  property and limit results to 2 per page, but start from the second page.

We know for the first page, the internal MongoDB `_id`  property of the last document was `5b7528ecb7d7c3728366810f`.

https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=[secret]&q={"tender.value.amount":{"$exists":true}}&limit=2&fromId=5b7528ecb7d7c3728366810f

#### **Count releases**

This is similar to the find releases endpoint above, except that it counts the items; hence it does not provide pagination.

**_Examples:_**

###### Counts all releases in the system

https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=[secret]

###### Count the releases in the system that have non-empty `tender.value.amount`

https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=[secret]&q={"tender.value.amount":{"$exists":true}}

**Advanced queries**

##### _Examples of advanced query parameters:_

###### Where a = b

You can build an endpoint in which you return the JSON documents where a field matches a specific value. For example, you could be looking for documents related to a specific buyer, supplier, procurement category, procurement method or status.

Query format: `&q={"fieldname":"fieldvalue"}`

**_Example query:_**

 -   Find documents where status is set to active: `&q={"status":"active"}`
 -   Find documents where the buyer.name is "Dinas Kesehatan": `&q={"buyer.name":"Dinas Kesehatan"}`
 -   Find documents where the budget is "APBD": `&q={"planning.budget.description":"APBD"}`
 -   Find documents where the mainProcurementCategory is "services" : `&q={"tender.mainProcurementCategory":"services"}`

**_Example endpoint:_**

 - **Count** the documents with mainProcurementCategory = "services" by using **count-releases:**
[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.mainProcurementCategory":"services"}](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q=%7B%22tender.mainProcurementCategory%22:%22services%22%7D)

- **List** the documents with mainProcurementCategory = "services" by using **find-releases:**
[`https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.mainProcurementCategory":"services"}`](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q=%7B%22tender.mainProcurementCategory%22:%22services%22%7D)

----------

###### Where (a=b) and (b=c)

Query format: `&q={"fieldname1":"fieldvalue1", "fieldname2":"fieldvalue2"}`

**_Example:_**  `&q={"buyer.name":"Dinas Kesehatan","planning.budget.description":"APBD"}`

- **Count** the documents with Dinas Kesehatan as a buyer and APBD as a budget by using **count-releases:**
[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"buyer.name":"Dinas Kesehatan","planning.budget.description":"APBD"}](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q=%7B%22buyer.name%22:%22Dinas%20Kesehatan%22,%22planning.budget.description%22:%22APBD%22%7D)

- **List** the documents with Dinas Kesehatan as a buyer and APBD as a budget by using **find-releases:**
[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"buyer.name":"Dinas Kesehatan","planning.budget.description":"APBD"}](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q=%7B%22buyer.name%22:%22Dinas%20Kesehatan%22,%22planning.budget.description%22:%22APBD%22%7D)

----------

**Where a in (b,c,d)**

Query format: `&q={$in["services", "works"]}`

----------

**Where a > n**

Query format: `&q={"tender.value.amount":{"$gt":100000}}`

----------

**Where a < n**

Query format: `&q={"tender.value.amount":{"$lt":100000}}`

----------

**Where a not equals n**

Query format: `&q={"fieldname": { "$ne": "fieldvalue"}}`

**_Example:_**  `&q={"tender.mainProcurementCategory": { $ne: "services"}}`

- **Count** the documents where the mainProcurementCategory is not "services" by using **count-releases:**
[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.mainProcurementCategory": { $ne: "services" }}]()
- **List** the documents where the mainProcurementCategory is not "services" by using **find-releases:**
[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.mainProcurementCategory": { $ne: "services" }}]()