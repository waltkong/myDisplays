package common

func MergeSlice(s1 []interface{}, s2 []interface{}) []interface{} {
	slice := make([]interface{}, len(s1)+len(s2))
	copy(slice, s1)
	copy(slice[len(s1):], s2)
	return slice
}

