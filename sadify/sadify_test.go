package sadify

import "testing"

func TestSadify(t *testing.T) {
	if Sadify() != "We'll miss you, Luke!" {
		t.Fatalf("Sadify does not say 'We'll miss you, Luke!'")
	}
}
