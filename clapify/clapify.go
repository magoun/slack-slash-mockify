package clapify

import "strings"

func Clapify(data []string) string {
	return strings.ToUpper(strings.Join(data, ":clap:")) + ":CLAP:"
}
