Feature: Login in the platform
  As a user
  I wanna be available to login in the platform

  Scenario: Login successfully as jorge
    Given a list of users persisted
    When I send a "POST" to "/auth/login" with:
    """
    {
      "_username": "jorge",
      "_password": "iyoque123"
    }
    """
    Then the response body match with file "login_ok" and status code is "200"

  Scenario: Try to login as jorge with wrong password
    Given a list of users persisted
    When I send a "POST" to "/auth/login" with:
    """
    {
      "_username": "jorge",
      "_password": "vaya, vaya cabesa"
    }
    """
    Then the response code is "401"
