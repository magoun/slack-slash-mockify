package clapify

import "testing"

func TestClapify(t *testing.T) {
	data := []string{
		"test",
		"clapify",
		"now",
	}

	if Clapify(data) != "TEST:CLAP:CLAPIFY:CLAP:NOW:CLAP:" {
		t.Fatalf("Clapify does not capitalize or delimit with claps")
	}
}
