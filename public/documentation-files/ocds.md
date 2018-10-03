### Understanding the fields

The data standard documentation is on [http://standard.open-contracting.org/latest/en/](http://standard.open-contracting.org/latest/en/)
This documentation provides details about the different stages of the procurement process, what fields you can find at each stage and what they mean.  

Bandung city publishes the following list of fields at each stage of the procurement process:

#### Planning

- planning.budget.amount.currency / bahasi : Titan insert the description here.
- planning.budget.project / Nama : Titan insert the description here.
- planning.budget.projectID / bahasi : Titan insert the description here.
- planning.budget.amount.amount / bahasi : Titan insert the description here.
- planning.budget.description / bahasi : Titan insert the description here.
- planning.budget.uri / bahasi : Titan insert the description here.
- planning.rationale / Ur_Sasaran: Titan insert the description here.

#### Tender

- tender.numberOfTenderers
- tender.value.amount
- tender.status
- tender.tenderers
- tender.title
- tender.awardCriteria
- tender.mainProcurementCategory
- tender.procurementMethod
- tender.tenderPeriod.startDate
- tender.tenderPeriod.endDate
- tender.contractPeriod.startDate
- tender.contractPeriod.endDate
- tender.procuringEntity

#### Award

- awards.id
- awards.title
- awards.description
- awards.status
- awards.date
- awards.value.amount
- awards.value.currency
- awards.suppliers.identifier.id
- awards.suppliers.identifier.legalName
- awards.suppliers.identifier.uri
- awards.suppliers.name
- awards.suppliers.address.streetAddress
- awards.suppliers.address.locality
- awards.suppliers.address.region
- awards.suppliers.address.postalCode
- awards.suppliers.address.countryName
- awards.suppliers.contactPoint.name
- awards.suppliers.contactPoint.email
- awards.suppliers.contactPoint.telephone
- awards.suppliers.contactPoint.faxNumber
- awards.items.id
- awards.items.description
- awards.items.classification.id
- awards.items.classification.description
- awards.items.quantity
- awards.items.unit.name
- awards.items.unit.value.amount
- awards.items.unit.value.currency
- awards.contractPeriod.startDate
- awards.contractPeriod.endDate


#### Contract

- contract.id
- contract.awardID
- contract.title
- contract.description
- contract.status
- contract.period.startDate
- contract.period.endDate
- contract.period.maxExtentDate
- contract.period.durationInDays
- contract.value.amount
- contract.value.currency
- contract.items.id
- contract.items.description
- contract.items.classification
- contract.items.quantity
- contract.items.unit
- contract.dateSigned
