package flagify

import "testing"

func TestFlagify(t *testing.T) {
	data := []string{
		"doin",
		"a",
		"test",
	}

	if Flagify(data) != ":flag-do::flag-in: :alphabet-white-a: :alphabet-white-t::flag-es::alphabet-white-t:" {
		t.Fatalf("Does not work, received: %s", Flagify(data))
	}
}
