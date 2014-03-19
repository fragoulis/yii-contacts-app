# Test Scenarios

There are mainly two types of scenarions we want to test. The first requires a model that only has one contact and thus requires a direct foreign key attribute (eg contact_id) that points to a Contact record. The second is about a model that can have multiple contacts and thus requires an *intermediate* table that will hold the related IDs (eg model_id, contact_id).

## Test Models
For the purpose of the tests we introduce two test models, namely **Person** and **Store**, where the 
Person is a mobile entiry and can have multiple Contacts and Store in a fixed location entity that
can only have one Contact.

# Test Cases
