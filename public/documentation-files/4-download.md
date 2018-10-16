## Downloading the data

**wget and curl**

wget and curl are two free open source command line tools to download data to your local computer.

You can use them as follow:

`curl -o <myfile.json> <endpoint>`  
`wget -o <myfile.json> <endpoint>`

###### curl:

`curl -o myfilename.json https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.value.amount":{"$exists":true}}&limit=25`

###### wget:

`wget -o myfilename.json https://webhooks.mongodb-stitch.com/api/client/v2.0/app/birms-cvrbm/service/query-birms/incoming_webhook/find-releases?secret=6WkBFKh6SS4ibE2O0Fm5UHGEQWv8hQbj&q={"tender.value.amount":{"$exists":true}}&limit=25`

### **Converting to CSV**

Once the data is on your computer, you can either use the data in its original JSON serialization by using a programming language such as Python or R, or you can flatten the data to a CSV file that can be opened in a spreadsheet.

The Open Contracting Data Standard (OCDS) has a CSV serialization that can be converted to/from the canonical JSON form using the OCDS Flatten-Tool.

More details about the flatten tool and how to use it can be found on: [https://flatten-tool.readthedocs.io/en/latest/usage-ocds](https://flatten-tool.readthedocs.io/en/latest/usage-ocds/).