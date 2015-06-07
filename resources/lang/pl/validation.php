<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => ":attribute musi zostać zaakceptowane.",
	"active_url"           => ":attribute nie jest poprawnym adresem URL.",
	"after"                => ":attribute musi być datą po :date.",
	"alpha"                => ":attribute może zawierać tylko litery.",
	"alpha_dash"           => ":attribute może zawierać tylko litery, cyfry i kreski.",
	"alpha_num"            => ":attribute może zawierać tylko litery i cyfry.",
	"array"                => ":attribute musi być tablicą.",
	"before"               => ":attribute musi być datą sprzed :date.",
	"between"              => [
		"numeric" => ":attribute musi być między :min a :max.",
		"file"    => "Rozmiar :attribute musi być między :min a :max kilobajtów.",
		"string"  => "Długość :attribute musi być między :min a :max znaków.",
		"array"   => ":attribute musi mieć między :min a :max elementów.",
	],
	"boolean"              => ":attribute musi mieć wartość true lub false.",
	"confirmed"            => "Potwierdzenie :attribute się nie zgadza.",
	"date"                 => ":attribute nie jest poprawną datą.",
	"date_format"          => ":attribute nie pasuje do formatu :format.",
	"different"            => ":attribute oraz :other muszą być różne.",
	"digits"               => ":attribute musi mieć :digits cyfr.",
	"digits_between"       => "Długość :attribute musi się mieścić między :min a :max cyframi.",
	"email"                => ":attribute musi być poprawnym adresem email.",
	"filled"               => "Pole :attribute jest niepoprawne.",
	"exists"               => "Wybrany :attribute jest niepoprawny.",
	"image"                => ":attribute musi być obrazkiem.",
	"in"                   => ":attribute jest niepoprawny.",
	"integer"              => ":attribute musi być liczbą całkowitą.",
	"ip"                   => ":attribute musi być poprawnym adresem IP.",
	"max"                  => [
		"numeric" => ":attribute musi mieć długość co najwyżej :max.",
		"file"    => ":attribute musi mieć co najwyżej :max kilobajtów.",
		"string"  => ":attribute musi mieć długość co najwyżej :max znaków.",
		"array"   => ":attribute musi mieć co najwyżej :max elementów.",
	],
	"mimes"                => ":attribute musi być plikiem typu: :values.",
	"min"                  => [
		"numeric" => ":attribute musi mieć długość co najmniej :min.",
		"file"    => ":attribute musi mieć co najmniej :min kilobajtów.",
		"string"  => ":attribute musi mieć długość co najmniej :min znaków.",
		"array"   => ":attribute musi mieć co najmnniej :min elementów.",
	],
	"not_in"               => "Wybrana wartość :attribute jest niepoprawna.",
	"numeric"              => ":attribute musi być liczbą.",
	"regex"                => "Format :attribute jest niepoprawny.",
	"required"             => "Pole :attribute jest wymagane.",
	"required_if"          => "Pole :attribute jest wymagane, gdy pole :other zawiera :value.",
	"required_with"        => "Pole :attribute jest wymagane, gdy któreś z pól :values jest wypełnione.",
	"required_with_all"    => "Pole :attribute jest wymagane, gdy pola :values są wypełnione.",
	"required_without"     => "Pole :attribute jest wymagane, gdy pole :values nie jest wypełnione.",
	"required_without_all" => "Pole :attribute jest wymagane, gdy żadne z pól :values nie jest wypełnione.",
	"same"                 => ":attribute oraz :other muszą się zgadzać.",
	"size"                 => [
		"numeric" => ":attribute musi mieć rozmiar :size.",
		"file"    => ":attribute musi mieć rozmiar :size kilobajtów.",
		"string"  => ":attribute musi mieć długość :size znaków.",
		"array"   => ":attribute musi zawierać :size elementów.",
	],
	"unique"               => ":attribute jest już zajęty.",
	"url"                  => "Format :attribute jest niepoprawny.",
	"timezone"             => ":attribute musi być poprawną strefą czasową.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
		'attribute-name' => [
			'rule-name' => 'custom-message',
		],
		'major-general' => [
			'required' => "Potrzebujesz prawdziwego wzorca współczesnego Majora-Generała, by założyć nową kolonię.",
			'min' => "Potrzebujesz prawdziwego wzorca współczesnego Majora-Generała, by założyć nową kolonię.",
			'max' => "Dobry Posejdonie, jeden Major-Generał wystarczy.",
		],
		'newport' => [
			'required' => "Arr! Nie możesz założyć nowego portu bez nadania mu nazwy, ty szczurze lądowy!",
			'unique' => "Arr! Ta nazwa portu jest już zajęta.",
		],
		'nazwa' => [
			'unique' => "Ta nazwa portu jest już zajęta.",
			'wolne_miejsce' => 'Wszystkie wyspy są zajęte. Nie możesz się zarejestrować na tym serwerze.'
		],
		'atak_jednostki' => [
			'max' => 'Nie możesz wysłać więcej jednostek niż posiadasz',
			'min' => 'Musisz wysłać przynajmniej jedną jednostkę, aby przeprowadzić atak'
		],
		'budynek' => [
			"not_enough" => "W porcie jest za mało surowców, by móc zbudować ",
		],
		'jednostka' => [
			"not_enough" => "W porcie jest za mało surowców, by móc zwerbować ",
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [],

];
