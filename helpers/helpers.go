package helpers

import (
	"encoding/base64"
	"net/url"
	"strings"
)

func LambdaParseFormData(requestBody string) map[string]string {
	stdDecodedBody, err := base64.StdEncoding.DecodeString(requestBody)

	if err != nil {
		panic(err)
	}

	keyValuePairs := strings.Split(string(stdDecodedBody), "&")

	formData := make(map[string]string)

	for _, pair := range keyValuePairs {
		pieces := strings.Split(pair, "=")

		key := pieces[0]
		value, err := url.QueryUnescape(pieces[1])

		if err != nil {
			panic(err)
		}

		formData[key] = value
	}

	return formData
}
