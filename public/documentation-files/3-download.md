### Downloading the data

wget and curl are two free open source command line tools that can download the data to your local computer.

You can use them as follow:

`curl -o <myfile.json> <endpoint>`  
`wget -o <myfile.json> <endpoint>`

###### curl

`curl -o myfilename.json  https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.value.amount":{"$exists":true}}&limit=25 `


###### wget

`wget -o myfilename.json  https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.value.amount":{"$exists":true}}&limit=25 `


### Converting to csv

Once the data is on your computer, you can do further transformation. For example, you can choose to flatten the json files to a   csv file.

The Open Contracting Data Standard (OCDS) has an unofficial CSV serialization that can be converted to/from the canonical JSON form using Flatten-Tool.

More details about the flatten tool and how to use can be found on:
[https://flatten-tool.readthedocs.io/en/latest/usage-ocds](https://flatten-tool.readthedocs.io/en/latest/usage-ocds/)
