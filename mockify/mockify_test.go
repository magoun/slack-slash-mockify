package mockify

import (
	"strings"
	"testing"
	"unicode"
)

func TestSameLetters(t *testing.T) {
	test := []string{
		"zyan",
		"busbus",
	}

	mockifiedText := Mockify(test)

	if strings.ToLower(mockifiedText) != strings.Join(test, " ") {
		t.Fatalf("Returned string is changed, received %s", mockifiedText)
	}
}

func TestBlendOfUpperAndLower(t *testing.T) {
	test := []string{
		"zyan",
		"busbus",
	}

	mockifiedText := Mockify(test)

	upper, lower := 0, 0

	for _, char := range mockifiedText {
		if unicode.IsLetter(char) {
			if unicode.IsUpper(char) {
				upper++
				lower = 0
			} else {
				lower++
				upper = 0
			}

			if lower > maxConsecutiveType || upper > maxConsecutiveType {
				t.Fatalf("Returned string violates maxConsecutiveType, received %s", mockifiedText)
			}
		}
	}
}
