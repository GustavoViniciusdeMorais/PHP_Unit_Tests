# PHP Unit

This repository contains source code examples about TDD with PHP.

src folder:
Contains the code to be tested under a namespace defined in the composer.json

tests folder:
Contains the tests under the namespace defined to Test in the composer.json

```
chmod +x composer.sh
./composer.sh

vendor/bin/phpunit tests

vendor/bin/phpunit tests --filter=ReceiptTest::testTax

vendor/bin/phpunit tests --filter=testTotal#1 // run the first data provider into the test
vendor/bin/phpunit tests --filter=testTotal#1-2 // run the first and data provider into the test
vendor/bin/phpunit tests --filter='testTotal@Test Case B' // run the test with the data provider key
```

# Test Pattern

## Arange-Act-Asset

* Arange: All necessary preconditions and inputs
    - Build a setUp method to start the objects of the test
* Act: On the object or method under test
    - Get the output of the method execution
    - The method must have the test word as first word on its name
* Assert: That the expected results have ocurred
    - Validate the output with an assertion

## TDD

* Write the test first
    - What should the input be?
    - What should the output be?
    - Run the built test, so its fails
    - Than build the method so the test passes