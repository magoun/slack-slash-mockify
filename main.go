package main

import (
	"context"
	"encoding/json"
	"fmt"
	"fusion/mockify/binify"
	"fusion/mockify/clapify"
	"fusion/mockify/flagify"
	"fusion/mockify/helpers"
	"fusion/mockify/mockify"
	"fusion/mockify/sadify"
	"fusion/mockify/shopify"
	"fusion/mockify/swearify"
	"fusion/mockify/timezonify"
	"strings"

	"github.com/aws/aws-lambda-go/events"
	"github.com/aws/aws-lambda-go/lambda"
)

type MockifyResponse struct {
	ResponseType string `json:"response_type"`
	Text         string `json:"text"`
}

func newMockifyResponse(responseText string) MockifyResponse {
	return MockifyResponse{ResponseType: "in_channel", Text: responseText}
}

func newEphemeralResponse(responseText string) MockifyResponse {
	return MockifyResponse{ResponseType: "ephemeral", Text: responseText}
}

func handleRequest(ctx context.Context, request events.APIGatewayProxyRequest) (events.APIGatewayProxyResponse, error) {
	var responseStruct MockifyResponse

	data := helpers.LambdaParseFormData(request.Body)
	text := data["text"]

	if text == "" {
		errorText := "Input text is required."
		responseStruct = newEphemeralResponse(errorText)
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

		responseStruct = newMockifyResponse(returnText)
	}

	fmt.Printf("Processing request data for request %s.\n", request.RequestContext.RequestID)
	fmt.Printf("Body size = %d.\n", len(request.Body))

	fmt.Println("Decoded request body:")
	fmt.Println(data)

	fmt.Println("Headers:")
	for key, value := range request.Headers {
		fmt.Printf("    %s: %s\n", key, value)
	}

	responseBody, err := json.Marshal(responseStruct)

	responseHeaders := map[string]string{
		"Content-Type": "application/json",
	}

	if err != nil {
		return events.APIGatewayProxyResponse{Headers: responseHeaders, Body: err.Error(), StatusCode: 500}, err
	}

	return events.APIGatewayProxyResponse{Headers: responseHeaders, Body: string(responseBody), StatusCode: 200}, nil
}

func main() {
	lambda.Start(handleRequest)
}
