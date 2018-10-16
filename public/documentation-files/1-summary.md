## Summary

Bandung City publishes its public procurement data according to the Open Contracting Data Standard (OCDS) version 1.1.3. The OCDS is a framework of good practices for the disclosure of contracting data and information. Please refer to the [OCDS website](http://standard.open-contracting.org/latest/en/) for more details on this standard.

Bandung City’s OCDS Application Processing Interface (API) allows users to access the data in JSON serialization to conduct analyses or build applications (e.g. software, websites, mobile apps).

The intended audience for this API documentation is the community of developers or data scientists. The documentation provides guidance as well as examples on how to:

-   Understand the data;
-   Query the API using MongoDB query language
-   Download the data in batch and convert the data to CSV format

**API Endpoints**

The base URL of Bandung City’s OCDS API is: https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/.

The secret key to access the API is: `6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj`.

The main queries supported by the API are the following:

-   `get-by-ocid:` get specific releases by OCID
-   `find-releases:` get all releases that meet a certain condition
-   `count-releases:` count the number of releases that meet a certain condition

**Examples:**

Get the releases with OCID “ocds-afzrfb-s-2016-5043143”:

[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/get-by-ocid?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&ocid=ocds-afzrfb-s-2016-5043143](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/get-by-ocid?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&ocid=ocds-afzrfb-s-2016-5043143)

Get all releases in the system, paginated using the default 20 items per page:

[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj)

Get the releases in the system that have non-empty tender.value.amount property and limit results to 50 per page:

[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.value.amount":{"$exists":true}}&limit=50]()

Count the releases in the system that have non-empty `tender.value.amount`

[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.value.amount":{"$exists":true}}]()

**Contribute**

For developers:

-   Write open source code that uses the data and don't forget to share the links to your online git repositories.
-   Share your most frequent queries. We will add them to the documentation and credit you.

For non-developers:

-   Tell us what you would like to ask the data.
-   Keep us posted on your finds.
-   Share your ideas to expand this project.