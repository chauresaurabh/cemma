"This function converts the numerical month to English month";
sub monthconvert {
	local ($month) = @_;
	if($month == 1|$month eq '01')
	{
		return 'Jan';
	}elsif
	($month == 2|$month eq '02')
	{
		return 'Feb';
	}elsif($month ==3|$month eq '03')
	{
		return 'Mar';
	}elsif
	($month == 4 |$month eq '04')
	{
		return 'Apr';
	}elsif($month ==5|$month eq '05')
	{
		return 'May';
	}elsif
	($month ==6|$month eq '06')
	{
		return 'Jun';
	}elsif($month ==7|$month eq '07')
	{
		return 'Jul';
	}elsif
	($month ==8|$month eq '08')
	{
		return 'Aug';
	}elsif($month ==9|$month eq '09')
	{
		return 'Sep';
	}elsif
	($month ==10)
	{
		return 'Oct';
	}elsif($month ==11)
	{
		return 'Nov';
	}elsif
	($month ==12)
	{
		return 'Dec';
	}
}
