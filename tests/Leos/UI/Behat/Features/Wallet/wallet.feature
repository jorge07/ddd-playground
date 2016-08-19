Feature: Wallet endpoint
  As a user
  I want test the wallet workflow

  Scenario: Create a new wallet and use it
    When I send a "POST" to "/api/v1/wallet.json" with:
    """
    {}
    """
    Then I should be redirected to resource
    And the response body match with file "get_wallet" and status code is "200"
    Then I send a "POST" to resource "/credit.json" with:
    """
    {
      "real": 100
    }
    """
    And the response body match with file "credit" and status code is "202"
    Then I send a "POST" to resource "/credit.json" with:
    """
    {
      "real": 9,
      "bonus": 24
    }
    """
    And the response code is "202"
    Then I send a "POST" to resource "/debit.json" with:
    """
    {
      "real": 64,
      "bonus": 4
    }
    """
    And the response body match with file "debit_final_behat" and status code is "202"


  Scenario: Try to get a non existent wallet
    When I send a "GET" request to "/api/v1/wallet/0cb00000-646e-11e6-a5a2-0000ac1b0000.json"
    And the response code is "404"


  Scenario: List the wallets
    Given a list of wallets persisted
    When I send a "GET" request to "/api/v1/wallet.json"
    And the response body match with file "cget_wallet" and status code is "200"


  Scenario: Filter the wallets
    Given a list of wallets persisted
    When I send a "GET" request to "/api/v1/wallet.json?filterParam[]=real.amount&filterOp[]=eq&filterValue[]=50"
    And the response body match with file "cget_wallet_filter_50" and status code is "200"
