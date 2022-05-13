package mockify

import (
	"math/rand"
	"strings"
	"unicode"
)

const maxConsecutiveType = 3

func Mockify(input []string) string {
	inputString := strings.Join(input, " ")
	upper, lower := 0, 0

	var mockifiedArr []rune

	upChar := func(char rune) rune {
		upper++
		lower = 0
		return unicode.ToUpper(char)
	}

	downChar := func(char rune) rune {
		lower++
		upper = 0
		return unicode.ToLower(char)
	}

	mockifyChar := func(char rune) rune {
		if upper-lower >= maxConsecutiveType {
			return downChar(char)
		} else if lower-upper >= maxConsecutiveType {
			return upChar(char)
		} else if rand.Intn(upper+lower+1) > lower {
			return downChar(char)
		} else {
			return upChar(char)
		}
	}

	for _, char := range inputString {
		if unicode.IsLetter(char) {
			char = mockifyChar(char)
		}

		mockifiedArr = append(mockifiedArr, char)
	}

	return string(mockifiedArr)
}
