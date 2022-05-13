package main

import (
	"encoding/json"
	"fusion/mockify/binify"
	"fusion/mockify/clapify"
	"fusion/mockify/flagify"
	"fusion/mockify/mockify"
	"fusion/mockify/sadify"
	"fusion/mockify/shopify"
	"fusion/mockify/swearify"
	"fusion/mockify/timezonify"
	"log"
	"net/http"
	"strings"
)

func main() {
	http.HandleFunc("/mockify", func(w http.ResponseWriter, r *http.Request) {
		if r.Method != "POST" {
			http.Error(w, "Not found", http.StatusNotFound)
		} else {
			text := r.PostFormValue("text")
			if text == "" {
				http.Error(w, "Text postform must be provided", http.StatusBadRequest)
			} else {
				var returnText string
				pieces := strings.Split(text, " ")

				switch pieces[0] {
				case "shopify":
					returnText = shopify.Shopify()
				case "swearify":
					returnText = swearify.Swearify()
				case "sadify":
					returnText = sadify.Sadify()
				case "clapify":
					returnText = clapify.Clapify(pieces[1:])
				case "debinify":
					returnText = binify.De(pieces[1:])
				case "binify":
					returnText = binify.Re(pieces[1:])
				case "flagify":
					returnText = flagify.Flagify(pieces[1:])
				case "timezonify":
					returnText = timezonify.Timezonify(pieces[1:])
				default:
					returnText = mockify.Mockify(pieces)
				}

				writeResponse(w, returnText)
			}
		}
	})

	log.Fatal(http.ListenAndServe(":3000", nil))
}

func writeResponse(w http.ResponseWriter, text string) {
	w.Header().Set("Content-Type", "application/json")
	w.WriteHeader(http.StatusOK)

	resp := map[string]string{
		"response_type": "in_channel",
		"text":          text,
	}

	jsonResp, err := json.Marshal(resp)

	if err != nil {
		log.Fatalf("Error happened in JSON marshal. Err: %s", err)
	}

	w.Write(jsonResp)
	return
}
