## Summary

Bandung city publishes it contracting data based on the Open Contracting Data Standard 1.1.3. Please refer to official standard documentation for more details.

We built an API that supports the following:
  - Finding data through a unique identifier called the Open Contracting Id (OCID).
  - Searching for data by using the rich MongoDB Query language.
  - Counting data that fits your specific criteria.

The query API is not public. All API access requires a key provided as the parameter `secret`.
This key is provided by the Bandung OC team. The current key is: `6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj`

The intended audience for this documentation is developers or data scientists who have familiarity working with data and know the basic concepts of an API. For non-technical readers, please check out [this page](http://www.google.com).

##### Show, not just tell
Instead of only telling you how to use the API, we are sharing examples as well. This is why we are working on these additional resources:
  - Samples for how to do common operations like batch download the data or convert to csv.
  - Code samples in Python, R and Javascript.
  - Detailed description of MongoDB Query language and frequently used queries.
  - Links to Open source tools built by the Open Contracting community.

We will continue adding code samples and contributions to our documentation. Make sure to check back again.

##### API Endpoints

The base url is: ```https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/```

The API endpoints use the following verbs:
  - ```get-by-ocid```
  - ```find-releases```
  - ```count-releases```



##### Examples

Get the release with ocid `ocds-afzrfb-s-2016-5043143`.

[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/get-by-ocid?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&ocid=ocds-afzrfb-s-2016-5043143](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/get-by-ocid?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&ocid=ocds-afzrfb-s-2016-5043143)


Get all releases in the system, paginated using the default 20 items per page

[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj)


Get the releases in the system that have non-empty `tender.value.amount` property and limit results to 50 per page

[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.value.amount":{"$exists":true}}&limit=25](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.value.amount":{"$exists":true}}&limit=25)


Count the releases in the system that have non-empty `tender.value.amount`

[https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.value.amount":{"$exists":true}}](https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/count-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.value.amount":{"$exists":true}})


##### Contribute

###### For Developers:
- Consider joining the Bandung Open Contracting Gitter channel, you can chat with the team and collaborate with others.
- Tell us about your most used queries. We'll add them to the documentation and credit you.
- Write open source code that uses the data and don't forget to send us those links to your online git repositories.

###### For Experts and community members:
- Give developers good ideas and tell us what you would like to ask the data.
- We love it when people put our hard work to good use. So, give  us ideas to expand this project and keep us posted on your finds.
