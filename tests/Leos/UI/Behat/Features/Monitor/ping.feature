Feature: Ping endpoint
  As an admin
  I want monitor the project

  Scenario: Create a new wallet
    When I send a "GET" request to "/api/v1/monitor/ping.json"
    And the response body match with file "ping" and status code is "200"
