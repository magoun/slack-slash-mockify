package binify

import "testing"

func TestDe(t *testing.T) {
	data := []string{
		"1110011",
		"1110100",
		"100000",
		"1100111",
		"1100101",
		"1110100",
		"1110100",
		"1101001",
		"1101110",
		"1100111",
		"100000",
		"1110100",
		"1100101",
		"1110011",
		"1110100",
		"100000",
		"1100100",
		"1100001",
		"1110100",
		"1100001",
	}

	if De(data) != "st getting test data" {
		t.Fatalf("incorrect binary conversion, got '%s'", De(data))
	}
}

func TestRe(t *testing.T) {
	data := []string{
		"just",
		"getting",
		"test",
		"data",
	}

	if Re(data) != "1101010 1110101 1110011 1110100 100000 1100111 1100101 1110100 1110100 1101001 1101110 1100111 100000 1110100 1100101 1110011 1110100 100000 1100100 1100001 1110100 1100001" {
		t.Fatalf("incorrect binary conversion, got '%s'", Re(data))
	}
}
