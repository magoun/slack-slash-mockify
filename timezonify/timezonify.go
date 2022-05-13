package timezonify

import (
	"fmt"
	"strings"
	"time"
)

const inForm = "01/02/2006 15:04"
const outForm = "3:04pm"

func Timezonify(input []string) string {

	zones := map[string]string{
		"Pacific":  "America/Los_Angeles",
		"Central":  "America/Chicago",
		"Eastern":  "America/New_York",
		"Brasilia": "America/Sao_Paulo",
		"India":    "Asia/Kolkata",
	}

	keys := []string{
		"Pacific",
		"Central",
		"Eastern",
		"Brasilia",
		"India",
	}

	now := time.Now()
	today := now.Format("01/02/2006")

	modInput := fmt.Sprintf(today + " " + input[0])

	inputLoc, _ := time.LoadLocation(zones["Central"])
	inputTime, _ := time.ParseInLocation(inForm, modInput, inputLoc)

	var returnTimes []string

	for _, name := range keys {
		tp := newTimePiece(name, zones[name], inputTime)
		returnTimes = append(returnTimes, tp.print())
	}

	return strings.Join(returnTimes, "\n")
}

type timePiece struct {
	name string
	time string
}

func newTimePiece(name string, timezone string, inputTime time.Time) *timePiece {
	loc, _ := time.LoadLocation(timezone)
	localizedTime := inputTime.In(loc)

	t := timePiece{
		name: name,
		time: localizedTime.Format(outForm),
	}

	return &t
}

func (tp *timePiece) print() string {
	return fmt.Sprintf("%s Time: %s", tp.name, tp.time)
}
