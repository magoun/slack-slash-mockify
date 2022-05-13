package binify

import (
	"bytes"
	"fmt"
	"strconv"
	"strings"
)

func De(data []string) string {
	var ints []int64
	for i, v := range data {
		tmp, err := strconv.ParseInt(v, 2, 8)

		ints = append(ints, tmp)

		if err != nil {
			ints[i] = 0
		}
	}

	var runes []rune

	for _, v := range ints {
		runes = append(runes, rune(v))
	}

	return string(runes)
}

func Re(data []string) string {
	var out []string

	for _, word := range data {
		for _, c := range word + " " {
			var buffer bytes.Buffer
			fmt.Fprintf(&buffer, "%b", c)
			out = append(out, buffer.String())
		}
	}

	return strings.Join(out[:len(out)-1], " ")
}
