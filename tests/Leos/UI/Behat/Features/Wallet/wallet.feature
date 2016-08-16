Feature: Wallet endpoint
  As a user
  I want test the wallet workflow

  Scenario: Create a new wallet
    When I send a "POST" to "/api/v1/wallet.json" with:
    """
    {
      "real": 100,
      "bonus": 0
    }
    """
    Then I should be redirected to resource
    And the response body match with file "get_wallet" and status code is "200"
    Then I send a "POST" to resource "/credit.json" with:
    """
    {
      "real": 99
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
    And the response body match with file "debit" and status code is "202"

