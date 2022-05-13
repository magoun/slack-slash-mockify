package timezonify

import (
	"strings"
	"testing"
)

func TestTimezonify(t *testing.T) {
	data := []string{"14:30"}

	expectedArr := []string{
		"Pacific Time: 12:30pm",
		"Central Time: 2:30pm",
		"Eastern Time: 3:30pm",
		"Brasilia Time: 5:30pm",
		"India Time: 2:00am",
	}

	result := Timezonify(data)

	if result != strings.Join(expectedArr, "\n") {
		t.Fatalf("Does not work, received: %s", result)
	}

}
