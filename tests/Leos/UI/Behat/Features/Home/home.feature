Feature: Home endpoint
  As an user
  I want see the home

  Scenario: List home
    When I send a "GET" request to "/api/v1/"
    And the response body match with file "home" and status code is "200"
