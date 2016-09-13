Feature: Register a new user in the platform
  As a user
  I wanna be available to register in the platform

  Scenario: Register successfully as paco
    When I send a "POST" to "/auth/register" with:
    """
    {
       "username": "paco",
       "email": "paco@gmail.com",
       "password": "qweqwe1234567890"
    }
    """
    Then the response code is "201"

  Scenario: Try to register as paco with wrong password
    Given a list of users persisted
    When I send a "POST" to "/auth/register" with:
    """
    {
       "username": "paco",
       "email": "paco@gmail.com",
       "password": "123"
    }
    """
    Then the response body match with file "wrong_password_scenario" and status code is "400"

  Scenario: Try to register as paco with wrong email
    When I send a "POST" to "/auth/register" with:
    """
    {
       "username": "paco",
       "email": "paco",
       "password": "987654321987"
    }
    """
    Then the response body match with file "wrong_email_scenario" and status code is "400"
