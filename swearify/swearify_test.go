package swearify

import "testing"

func TestSwear(t *testing.T) {
	if find(Swears(), Swearify()) == -1 {
		t.Fatalf("Swear not found")
	}
}

func find(slice []string, val string) int {
	for i, v := range slice {
		if v == val {
			return i
		}
	}

	return -1
}
