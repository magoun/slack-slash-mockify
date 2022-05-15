package helpers

import (
	"testing"
)

func TestLambdaParseFormData(t *testing.T) {
	data := "dG9rZW49RHNKajN6MUNYWjQyQXA5ZG1nTUFIa1N3JnRlYW1faWQ9VDAyOVRIQVRYJnRlYW1fZG9tYWluPXRoZXJhcHlicmFuZHMmY2hhbm5lbF9pZD1EUUY4NTNSSEEmY2hhbm5lbF9uYW1lPWRpcmVjdG1lc3NhZ2UmdXNlcl9pZD1VUUZNVDVQSDYmdXNlcl9uYW1lPWNyZWlnaHRvbiZjb21tYW5kPSUyRm1vY2tpZnkmdGV4dD10ZXN0aW5nc3R1ZmYlM0Rtb3Jlc3R1ZmYmaXNfZW50ZXJwcmlzZV9pbnN0YWxsPWZhbHNlJnJlc3BvbnNlX3VybD1odHRwcyUzQSUyRiUyRmhvb2tzLnNsYWNrLmNvbSUyRmNvbW1hbmRzJTJGVDAyOVRIQVRYJTJGMzUyMTUyMzc3MTY1MyUyRjhpNlpaYWNRdzI2NlZyVnBzejVwUmw1Yg=="

	expected := map[string]string{
		"channel_id":            "DQF853RHA",
		"channel_name":          "directmessage",
		"command":               "/mockify",
		"is_enterprise_install": "false",
		"response_url":          "https://hooks.slack.com/commands/T029THATX/3521523771653/8i6ZZacQw266VrVpsz5pRl5b",
		"team_domain":           "therapybrands",
		"team_id":               "T029THATX",
		"text":                  "testingstuff=morestuff",
		"token":                 "DsJj3z1CXZ42Ap9dmgMAHkSw",
		"user_id":               "UQFMT5PH6",
		"user_name":             "creighton",
	}

	result := LambdaParseFormData(data)

	for key, value := range expected {
		if result[key] != value {
			t.Fatalf("Does not work, received: %s", result)
		}
	}

}
