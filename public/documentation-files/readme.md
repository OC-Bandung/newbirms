# OCDS Bandung Release query API

## General information

The query API is not public.
All API access requires a key provided as the parameter `secret`.
This key will be provided on demand by the Bandung OC team.

## Get release by ocid

`https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/get-by-ocid?secret=[secret]&ocid=[ocid]`

Get one OCDS release document for the release with the given `ocid`.

Example:

### Gets the release with ocid `ocds-afzrfb-s-2016-5043143`

`https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/get-by-ocid?secret=[secret]&ocid=ocds-afzrfb-s-2016-5043143`

## Find releases using an optional MongoDB query and pagination.

The following URL will search the database for all releases and optionally filter
them by the given query using the `q` parameter. It can also limit the number of results
returned by the use of `limit` parameter, with a default value of 20.
Pagination is provided using the last MongoDB document with `_id` displayed, using `fromId` parameter.
This is an efficient results pagination method described in detail here (Approach 2):
https://www.codementor.io/arpitbhayani/fast-and-efficient-pagination-in-mongodb-9095flbqr

The query syntax of the `q` parameter follows the MongoDB query syntax
https://docs.mongodb.com/manual/tutorial/query-documents/

Examples:

### Get all releases in the system, paginated using the default 20 items per page

`https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=[secret]`

### Get all releases in the system, paginated using 100 items per page

`https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=[secret]&limit=100`

### Get the releases in the system that have non-empty `tender.value.amount` property and limit results to 50 per page

`https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=[secret]&q={"tender.value.amount":{"$exists":true}}&limit=50`

### Get the releases in the system that have non-empty `tender.value.amount` property and limit results to 2 per page, but start from the second page.

We know for the first page, the internal MongoDB `_id` property of the last document was `5b7528ecb7d7c3728366810f`.

`https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=[secret]&q={"tender.value.amount":{"$exists":true}}&limit=2&fromId=5b7528ecb7d7c3728366810f`

## Count releases using an optional MongoDB query

This is similar to find releases endpoint above, but it just counts the items, hence
it does not provide pagination.

Examples:

### Counts all releases in the system

`https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=[secret]`

### Count the releases in the system that have non-empty `tender.value.amount`

`https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=[secret]&q={"tender.value.amount":{"$exists":true}}`

## Find errors during data import

`https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-errors?secret=[secret]`

## Count errors during data import

`https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-errors?secret=[secret]`
