<?php
    $api_data = '{
  "meta": {
    "count": 7,
    "links": {
      "self": "https://test.api.amadeus.com/v2/shopping/flight-offers?originLocationCode=DEL&destinationLocationCode=DXB&departureDate=2024-08-15&adults=1&travelClass=PREMIUM_ECONOMY&nonStop=false&currencyCode=INR&max=250"
    }
  },
  "data": [
    {
      "type": "flight-offer",
      "id": "1",
      "source": "GDS",
      "instantTicketingRequired": false,
      "nonHomogeneous": false,
      "oneWay": false,
      "isUpsellOffer": false,
      "lastTicketingDate": "2024-08-15",
      "lastTicketingDateTime": "2024-08-15",
      "numberOfBookableSeats": 9,
      "itineraries": [
        {
          "duration": "PT9H25M",
          "segments": [
            {
              "departure": {
                "iataCode": "DEL",
                "terminal": "3",
                "at": "2024-08-15T10:20:00"
              },
              "arrival": {
                "iataCode": "BOM",
                "terminal": "2",
                "at": "2024-08-15T12:35:00"
              },
              "carrierCode": "UK",
              "number": "995",
              "aircraft": {
                "code": "320"
              },
              "operating": {
                "carrierCode": "UK"
              },
              "duration": "PT2H15M",
              "id": "1",
              "numberOfStops": 0,
              "blacklistedInEU": false
            },
            {
              "departure": {
                "iataCode": "BOM",
                "terminal": "2",
                "at": "2024-08-15T16:25:00"
              },
              "arrival": {
                "iataCode": "DXB",
                "terminal": "1",
                "at": "2024-08-15T18:15:00"
              },
              "carrierCode": "UK",
              "number": "201",
              "aircraft": {
                "code": "321"
              },
              "operating": {
                "carrierCode": "UK"
              },
              "duration": "PT3H20M",
              "id": "2",
              "numberOfStops": 0,
              "blacklistedInEU": false
            }
          ]
        }
      ],
      "price": {
        "currency": "INR",
        "total": "34566.00",
        "base": "29355.00",
        "fees": [
          {
            "amount": "0.00",
            "type": "SUPPLIER"
          },
          {
            "amount": "0.00",
            "type": "TICKETING"
          }
        ],
        "grandTotal": "34566.00"
      },
      "pricingOptions": {
        "fareType": [
          "PUBLISHED"
        ],
        "includedCheckedBagsOnly": true
      },
      "validatingAirlineCodes": [
        "UK"
      ],
      "travelerPricings": [
        {
          "travelerId": "1",
          "fareOption": "STANDARD",
          "travelerType": "ADULT",
          "price": {
            "currency": "INR",
            "total": "34566.00",
            "base": "29355.00"
          },
          "fareDetailsBySegment": [
            {
              "segmentId": "1",
              "cabin": "PREMIUM_ECONOMY",
              "fareBasis": "POINPV",
              "brandedFare": "PREPV",
              "brandedFareLabel": "PEY VALUE",
              "class": "P",
              "includedCheckedBags": {
                "weight": 35,
                "weightUnit": "KG"
              },
              "amenities": [
                {
                  "description": "VISTARA SELECT",
                  "isChargeable": false,
                  "amenityType": "PRE_RESERVED_SEAT",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "MEAL SERVICES",
                  "isChargeable": false,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "PRIORITY CHECK IN",
                  "isChargeable": false,
                  "amenityType": "TRAVEL_SERVICES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "PRIORITY BOARDING",
                  "isChargeable": false,
                  "amenityType": "TRAVEL_SERVICES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "PRIORITY BAGGAGE HANDLING",
                  "isChargeable": false,
                  "amenityType": "TRAVEL_SERVICES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "UPGRADE ELIGIBILITY",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE ANYTIME",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                }
              ]
            },
            {
              "segmentId": "2",
              "cabin": "PREMIUM_ECONOMY",
              "fareBasis": "POINPV",
              "brandedFare": "PREPV",
              "brandedFareLabel": "PEY VALUE",
              "class": "P",
              "includedCheckedBags": {
                "weight": 35,
                "weightUnit": "KG"
              },
              "amenities": [
                {
                  "description": "VISTARA SELECT",
                  "isChargeable": false,
                  "amenityType": "PRE_RESERVED_SEAT",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "MEAL SERVICES",
                  "isChargeable": false,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "PRIORITY CHECK IN",
                  "isChargeable": false,
                  "amenityType": "TRAVEL_SERVICES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "PRIORITY BOARDING",
                  "isChargeable": false,
                  "amenityType": "TRAVEL_SERVICES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "PRIORITY BAGGAGE HANDLING",
                  "isChargeable": false,
                  "amenityType": "TRAVEL_SERVICES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "UPGRADE ELIGIBILITY",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE ANYTIME",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                }
              ]
            }
          ]
        }
      ]
    },
    {
      "type": "flight-offer",
      "id": "2",
      "source": "GDS",
      "instantTicketingRequired": false,
      "nonHomogeneous": false,
      "oneWay": false,
      "isUpsellOffer": false,
      "lastTicketingDate": "2024-08-15",
      "lastTicketingDateTime": "2024-08-15",
      "numberOfBookableSeats": 9,
      "itineraries": [
        {
          "duration": "PT7H50M",
          "segments": [
            {
              "departure": {
                "iataCode": "DEL",
                "at": "2024-08-15T04:15:00"
              },
              "arrival": {
                "iataCode": "RUH",
                "terminal": "3",
                "at": "2024-08-15T06:10:00"
              },
              "carrierCode": "XY",
              "number": "330",
              "aircraft": {
                "code": "320"
              },
              "operating": {
                "carrierCode": "XY"
              },
              "duration": "PT4H25M",
              "id": "13",
              "numberOfStops": 0,
              "blacklistedInEU": false
            },
            {
              "departure": {
                "iataCode": "RUH",
                "terminal": "3",
                "at": "2024-08-15T07:40:00"
              },
              "arrival": {
                "iataCode": "DXB",
                "terminal": "1",
                "at": "2024-08-15T10:35:00"
              },
              "carrierCode": "XY",
              "number": "201",
              "aircraft": {
                "code": "320"
              },
              "operating": {
                "carrierCode": "XY"
              },
              "duration": "PT1H55M",
              "id": "14",
              "numberOfStops": 0,
              "blacklistedInEU": false
            }
          ]
        }
      ],
      "price": {
        "currency": "INR",
        "total": "41772.00",
        "base": "11690.00",
        "fees": [
          {
            "amount": "0.00",
            "type": "SUPPLIER"
          },
          {
            "amount": "0.00",
            "type": "TICKETING"
          }
        ],
        "grandTotal": "41772.00"
      },
      "pricingOptions": {
        "fareType": [
          "PUBLISHED"
        ],
        "includedCheckedBagsOnly": true
      },
      "validatingAirlineCodes": [
        "XY"
      ],
      "travelerPricings": [
        {
          "travelerId": "1",
          "fareOption": "STANDARD",
          "travelerType": "ADULT",
          "price": {
            "currency": "INR",
            "total": "41772.00",
            "base": "11690.00"
          },
          "fareDetailsBySegment": [
            {
              "segmentId": "13",
              "cabin": "PREMIUM_ECONOMY",
              "fareBasis": "JCFAREOW",
              "class": "J",
              "includedCheckedBags": {
                "quantity": 2
              }
            },
            {
              "segmentId": "14",
              "cabin": "PREMIUM_ECONOMY",
              "fareBasis": "JCFAREOW",
              "class": "J",
              "includedCheckedBags": {
                "quantity": 2
              }
            }
          ]
        }
      ]
    },
    {
      "type": "flight-offer",
      "id": "3",
      "source": "GDS",
      "instantTicketingRequired": false,
      "nonHomogeneous": false,
      "oneWay": false,
      "isUpsellOffer": false,
      "lastTicketingDate": "2024-08-15",
      "lastTicketingDateTime": "2024-08-15",
      "numberOfBookableSeats": 9,
      "itineraries": [
        {
          "duration": "PT12H40M",
          "segments": [
            {
              "departure": {
                "iataCode": "DEL",
                "at": "2024-08-15T04:15:00"
              },
              "arrival": {
                "iataCode": "RUH",
                "terminal": "3",
                "at": "2024-08-15T06:10:00"
              },
              "carrierCode": "XY",
              "number": "330",
              "aircraft": {
                "code": "320"
              },
              "operating": {
                "carrierCode": "XY"
              },
              "duration": "PT4H25M",
              "id": "3",
              "numberOfStops": 0,
              "blacklistedInEU": false
            },
            {
              "departure": {
                "iataCode": "RUH",
                "terminal": "3",
                "at": "2024-08-15T12:20:00"
              },
              "arrival": {
                "iataCode": "DXB",
                "terminal": "1",
                "at": "2024-08-15T15:25:00"
              },
              "carrierCode": "XY",
              "number": "205",
              "aircraft": {
                "code": "320"
              },
              "operating": {
                "carrierCode": "XY"
              },
              "duration": "PT2H5M",
              "id": "4",
              "numberOfStops": 0,
              "blacklistedInEU": false
            }
          ]
        }
      ],
      "price": {
        "currency": "INR",
        "total": "52148.00",
        "base": "26875.00",
        "fees": [
          {
            "amount": "0.00",
            "type": "SUPPLIER"
          },
          {
            "amount": "0.00",
            "type": "TICKETING"
          }
        ],
        "grandTotal": "52148.00"
      },
      "pricingOptions": {
        "fareType": [
          "PUBLISHED"
        ],
        "includedCheckedBagsOnly": true
      },
      "validatingAirlineCodes": [
        "XY"
      ],
      "travelerPricings": [
        {
          "travelerId": "1",
          "fareOption": "STANDARD",
          "travelerType": "ADULT",
          "price": {
            "currency": "INR",
            "total": "52148.00",
            "base": "26875.00"
          },
          "fareDetailsBySegment": [
            {
              "segmentId": "3",
              "cabin": "PREMIUM_ECONOMY",
              "fareBasis": "JFAREOW",
              "class": "J",
              "includedCheckedBags": {
                "quantity": 2
              }
            },
            {
              "segmentId": "4",
              "cabin": "ECONOMY",
              "fareBasis": "HVALOW",
              "class": "H",
              "includedCheckedBags": {
                "quantity": 2
              }
            }
          ]
        }
      ]
    },
    {
      "type": "flight-offer",
      "id": "4",
      "source": "GDS",
      "instantTicketingRequired": false,
      "nonHomogeneous": false,
      "oneWay": false,
      "isUpsellOffer": false,
      "lastTicketingDate": "2024-08-09",
      "lastTicketingDateTime": "2024-08-09",
      "numberOfBookableSeats": 9,
      "itineraries": [
        {
          "duration": "PT20H40M",
          "segments": [
            {
              "departure": {
                "iataCode": "DEL",
                "terminal": "3",
                "at": "2024-08-15T02:50:00"
              },
              "arrival": {
                "iataCode": "FRA",
                "terminal": "1",
                "at": "2024-08-15T08:15:00"
              },
              "carrierCode": "LH",
              "number": "761",
              "aircraft": {
                "code": "346"
              },
              "operating": {
                "carrierCode": "LH"
              },
              "duration": "PT8H55M",
              "id": "5",
              "numberOfStops": 0,
              "blacklistedInEU": false
            },
            {
              "departure": {
                "iataCode": "FRA",
                "terminal": "1",
                "at": "2024-08-15T18:00:00"
              },
              "arrival": {
                "iataCode": "DXB",
                "at": "2024-08-15T22:00:00"
              },
              "carrierCode": "LH",
              "number": "4556",
              "aircraft": {
                "code": "744"
              },
              "operating": {
                "carrierCode": "LH"
              },
              "duration": "PT2H",
              "id": "6",
              "numberOfStops": 0,
              "blacklistedInEU": false
            }
          ]
        }
      ],
      "price": {
        "currency": "INR",
        "total": "99900.00",
        "base": "57070.00",
        "fees": [
          {
            "amount": "0.00",
            "type": "SUPPLIER"
          },
          {
            "amount": "0.00",
            "type": "TICKETING"
          }
        ],
        "grandTotal": "99900.00"
      },
      "pricingOptions": {
        "fareType": [
          "PUBLISHED"
        ],
        "includedCheckedBagsOnly": true
      },
      "validatingAirlineCodes": [
        "LH"
      ],
      "travelerPricings": [
        {
          "travelerId": "1",
          "fareOption": "STANDARD",
          "travelerType": "ADULT",
          "price": {
            "currency": "INR",
            "total": "99900.00",
            "base": "57070.00"
          },
          "fareDetailsBySegment": [
            {
              "segmentId": "5",
              "cabin": "PREMIUM_ECONOMY",
              "fareBasis": "ENCOW3AA",
              "brandedFare": "PRESAVER",
              "brandedFareLabel": "PREMIUM ECONOMY SAVER",
              "class": "E",
              "includedCheckedBags": {
                "quantity": 2
              },
              "amenities": [
                {
                  "description": "CATERING ON EUROPE FLTS",
                  "isChargeable": true,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CATERING ON INTERCONT FLTS",
                  "isChargeable": false,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "STANDARD SEAT RESERVATION",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "MILEAGE ACCRUAL",
                  "isChargeable": false,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "UPGRADE ELIGIBILITY",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE BEFORE DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE AFTER DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                }
              ]
            },
            {
              "segmentId": "6",
              "cabin": "PREMIUM_ECONOMY",
              "fareBasis": "ENCOW3AA",
              "brandedFare": "PRESAVER",
              "brandedFareLabel": "PREMIUM ECONOMY SAVER",
              "class": "E",
              "includedCheckedBags": {
                "quantity": 2
              },
              "amenities": [
                {
                  "description": "CATERING ON EUROPE FLTS",
                  "isChargeable": true,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CATERING ON INTERCONT FLTS",
                  "isChargeable": false,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "STANDARD SEAT RESERVATION",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "MILEAGE ACCRUAL",
                  "isChargeable": false,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "UPGRADE ELIGIBILITY",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE BEFORE DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE AFTER DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                }
              ]
            }
          ]
        }
      ]
    },
    {
      "type": "flight-offer",
      "id": "5",
      "source": "GDS",
      "instantTicketingRequired": false,
      "nonHomogeneous": false,
      "oneWay": false,
      "isUpsellOffer": false,
      "lastTicketingDate": "2024-08-09",
      "lastTicketingDateTime": "2024-08-09",
      "numberOfBookableSeats": 9,
      "itineraries": [
        {
          "duration": "PT21H40M",
          "segments": [
            {
              "departure": {
                "iataCode": "DEL",
                "terminal": "3",
                "at": "2024-08-15T02:50:00"
              },
              "arrival": {
                "iataCode": "FRA",
                "terminal": "1",
                "at": "2024-08-15T08:15:00"
              },
              "carrierCode": "LH",
              "number": "761",
              "aircraft": {
                "code": "346"
              },
              "operating": {
                "carrierCode": "LH"
              },
              "duration": "PT8H55M",
              "id": "7",
              "numberOfStops": 0,
              "blacklistedInEU": false
            },
            {
              "departure": {
                "iataCode": "FRA",
                "terminal": "1",
                "at": "2024-08-15T13:30:00"
              },
              "arrival": {
                "iataCode": "DXB",
                "terminal": "1",
                "at": "2024-08-15T23:00:00"
              },
              "carrierCode": "LH",
              "number": "630",
              "aircraft": {
                "code": "359"
              },
              "operating": {
                "carrierCode": "LH"
              },
              "duration": "PT7H30M",
              "id": "8",
              "numberOfStops": 0,
              "blacklistedInEU": false
            }
          ]
        }
      ],
      "price": {
        "currency": "INR",
        "total": "99900.00",
        "base": "57070.00",
        "fees": [
          {
            "amount": "0.00",
            "type": "SUPPLIER"
          },
          {
            "amount": "0.00",
            "type": "TICKETING"
          }
        ],
        "grandTotal": "99900.00"
      },
      "pricingOptions": {
        "fareType": [
          "PUBLISHED"
        ],
        "includedCheckedBagsOnly": true
      },
      "validatingAirlineCodes": [
        "LH"
      ],
      "travelerPricings": [
        {
          "travelerId": "1",
          "fareOption": "STANDARD",
          "travelerType": "ADULT",
          "price": {
            "currency": "INR",
            "total": "99900.00",
            "base": "57070.00"
          },
          "fareDetailsBySegment": [
            {
              "segmentId": "7",
              "cabin": "PREMIUM_ECONOMY",
              "fareBasis": "ENCOW3AA",
              "brandedFare": "PRESAVER",
              "brandedFareLabel": "PREMIUM ECONOMY SAVER",
              "class": "E",
              "includedCheckedBags": {
                "quantity": 2
              },
              "amenities": [
                {
                  "description": "CATERING ON EUROPE FLTS",
                  "isChargeable": true,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CATERING ON INTERCONT FLTS",
                  "isChargeable": false,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "STANDARD SEAT RESERVATION",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "MILEAGE ACCRUAL",
                  "isChargeable": false,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "UPGRADE ELIGIBILITY",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE BEFORE DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE AFTER DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                }
              ]
            },
            {
              "segmentId": "8",
              "cabin": "PREMIUM_ECONOMY",
              "fareBasis": "ENCOW3AA",
              "brandedFare": "PRESAVER",
              "brandedFareLabel": "PREMIUM ECONOMY SAVER",
              "class": "E",
              "includedCheckedBags": {
                "quantity": 2
              },
              "amenities": [
                {
                  "description": "CATERING ON EUROPE FLTS",
                  "isChargeable": true,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CATERING ON INTERCONT FLTS",
                  "isChargeable": false,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "STANDARD SEAT RESERVATION",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "MILEAGE ACCRUAL",
                  "isChargeable": false,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "UPGRADE ELIGIBILITY",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE BEFORE DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE AFTER DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                }
              ]
            }
          ]
        }
      ]
    },
    {
      "type": "flight-offer",
      "id": "6",
      "source": "GDS",
      "instantTicketingRequired": false,
      "nonHomogeneous": false,
      "oneWay": false,
      "isUpsellOffer": false,
      "lastTicketingDate": "2024-08-09",
      "lastTicketingDateTime": "2024-08-09",
      "numberOfBookableSeats": 9,
      "itineraries": [
        {
          "duration": "PT21H40M",
          "segments": [
            {
              "departure": {
                "iataCode": "DEL",
                "terminal": "3",
                "at": "2024-08-15T02:50:00"
              },
              "arrival": {
                "iataCode": "FRA",
                "terminal": "1",
                "at": "2024-08-15T08:15:00"
              },
              "carrierCode": "LH",
              "number": "761",
              "aircraft": {
                "code": "346"
              },
              "operating": {
                "carrierCode": "LH"
              },
              "duration": "PT8H55M",
              "id": "9",
              "numberOfStops": 0,
              "blacklistedInEU": false
            },
            {
              "departure": {
                "iataCode": "FRA",
                "terminal": "1",
                "at": "2024-08-15T18:00:00"
              },
              "arrival": {
                "iataCode": "DXB",
                "at": "2024-08-15T23:00:00"
              },
              "carrierCode": "LH",
              "number": "4613",
              "aircraft": {
                "code": "74H"
              },
              "operating": {
                "carrierCode": "LH"
              },
              "duration": "PT3H",
              "id": "10",
              "numberOfStops": 0,
              "blacklistedInEU": false
            }
          ]
        }
      ],
      "price": {
        "currency": "INR",
        "total": "99900.00",
        "base": "57070.00",
        "fees": [
          {
            "amount": "0.00",
            "type": "SUPPLIER"
          },
          {
            "amount": "0.00",
            "type": "TICKETING"
          }
        ],
        "grandTotal": "99900.00"
      },
      "pricingOptions": {
        "fareType": [
          "PUBLISHED"
        ],
        "includedCheckedBagsOnly": true
      },
      "validatingAirlineCodes": [
        "LH"
      ],
      "travelerPricings": [
        {
          "travelerId": "1",
          "fareOption": "STANDARD",
          "travelerType": "ADULT",
          "price": {
            "currency": "INR",
            "total": "99900.00",
            "base": "57070.00"
          },
          "fareDetailsBySegment": [
            {
              "segmentId": "9",
              "cabin": "PREMIUM_ECONOMY",
              "fareBasis": "ENCOW3AA",
              "brandedFare": "PRESAVER",
              "brandedFareLabel": "PREMIUM ECONOMY SAVER",
              "class": "E",
              "includedCheckedBags": {
                "quantity": 2
              },
              "amenities": [
                {
                  "description": "CATERING ON EUROPE FLTS",
                  "isChargeable": true,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CATERING ON INTERCONT FLTS",
                  "isChargeable": false,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "STANDARD SEAT RESERVATION",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "MILEAGE ACCRUAL",
                  "isChargeable": false,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "UPGRADE ELIGIBILITY",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE BEFORE DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE AFTER DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                }
              ]
            },
            {
              "segmentId": "10",
              "cabin": "PREMIUM_ECONOMY",
              "fareBasis": "ENCOW3AA",
              "brandedFare": "PRESAVER",
              "brandedFareLabel": "PREMIUM ECONOMY SAVER",
              "class": "E",
              "includedCheckedBags": {
                "quantity": 2
              },
              "amenities": [
                {
                  "description": "CATERING ON EUROPE FLTS",
                  "isChargeable": true,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CATERING ON INTERCONT FLTS",
                  "isChargeable": false,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "STANDARD SEAT RESERVATION",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "MILEAGE ACCRUAL",
                  "isChargeable": false,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "UPGRADE ELIGIBILITY",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE BEFORE DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE AFTER DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                }
              ]
            }
          ]
        }
      ]
    },
    {
      "type": "flight-offer",
      "id": "7",
      "source": "GDS",
      "instantTicketingRequired": false,
      "nonHomogeneous": false,
      "oneWay": false,
      "isUpsellOffer": false,
      "lastTicketingDate": "2024-08-09",
      "lastTicketingDateTime": "2024-08-09",
      "numberOfBookableSeats": 9,
      "itineraries": [
        {
          "duration": "PT21H40M",
          "segments": [
            {
              "departure": {
                "iataCode": "DEL",
                "terminal": "3",
                "at": "2024-08-15T02:50:00"
              },
              "arrival": {
                "iataCode": "FRA",
                "terminal": "1",
                "at": "2024-08-15T08:15:00"
              },
              "carrierCode": "LH",
              "number": "761",
              "aircraft": {
                "code": "346"
              },
              "operating": {
                "carrierCode": "LH"
              },
              "duration": "PT8H55M",
              "id": "11",
              "numberOfStops": 0,
              "blacklistedInEU": false
            },
            {
              "departure": {
                "iataCode": "FRA",
                "terminal": "1",
                "at": "2024-08-15T19:00:00"
              },
              "arrival": {
                "iataCode": "DXB",
                "at": "2024-08-15T23:00:00"
              },
              "carrierCode": "LH",
              "number": "4969",
              "aircraft": {
                "code": "744"
              },
              "operating": {
                "carrierCode": "LH"
              },
              "duration": "PT2H",
              "id": "12",
              "numberOfStops": 0,
              "blacklistedInEU": false
            }
          ]
        }
      ],
      "price": {
        "currency": "INR",
        "total": "99900.00",
        "base": "57070.00",
        "fees": [
          {
            "amount": "0.00",
            "type": "SUPPLIER"
          },
          {
            "amount": "0.00",
            "type": "TICKETING"
          }
        ],
        "grandTotal": "99900.00"
      },
      "pricingOptions": {
        "fareType": [
          "PUBLISHED"
        ],
        "includedCheckedBagsOnly": true
      },
      "validatingAirlineCodes": [
        "LH"
      ],
      "travelerPricings": [
        {
          "travelerId": "1",
          "fareOption": "STANDARD",
          "travelerType": "ADULT",
          "price": {
            "currency": "INR",
            "total": "99900.00",
            "base": "57070.00"
          },
          "fareDetailsBySegment": [
            {
              "segmentId": "11",
              "cabin": "PREMIUM_ECONOMY",
              "fareBasis": "ENCOW3AA",
              "brandedFare": "PRESAVER",
              "brandedFareLabel": "PREMIUM ECONOMY SAVER",
              "class": "E",
              "includedCheckedBags": {
                "quantity": 2
              },
              "amenities": [
                {
                  "description": "CATERING ON EUROPE FLTS",
                  "isChargeable": true,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CATERING ON INTERCONT FLTS",
                  "isChargeable": false,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "STANDARD SEAT RESERVATION",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "MILEAGE ACCRUAL",
                  "isChargeable": false,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "UPGRADE ELIGIBILITY",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE BEFORE DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE AFTER DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                }
              ]
            },
            {
              "segmentId": "12",
              "cabin": "PREMIUM_ECONOMY",
              "fareBasis": "ENCOW3AA",
              "brandedFare": "PRESAVER",
              "brandedFareLabel": "PREMIUM ECONOMY SAVER",
              "class": "E",
              "includedCheckedBags": {
                "quantity": 2
              },
              "amenities": [
                {
                  "description": "CATERING ON EUROPE FLTS",
                  "isChargeable": true,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CATERING ON INTERCONT FLTS",
                  "isChargeable": false,
                  "amenityType": "MEAL",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "STANDARD SEAT RESERVATION",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "MILEAGE ACCRUAL",
                  "isChargeable": false,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "UPGRADE ELIGIBILITY",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE BEFORE DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                },
                {
                  "description": "CHANGE AFTER DEPARTURE",
                  "isChargeable": true,
                  "amenityType": "BRANDED_FARES",
                  "amenityProvider": {
                    "name": "BrandedFare"
                  }
                }
              ]
            }
          ]
        }
      ]
    }
  ],
  "dictionaries": {
    "locations": {
      "BOM": {
        "cityCode": "BOM",
        "countryCode": "IN"
      },
      "RUH": {
        "cityCode": "RUH",
        "countryCode": "SA"
      },
      "FRA": {
        "cityCode": "FRA",
        "countryCode": "DE"
      },
      "DEL": {
        "cityCode": "DEL",
        "countryCode": "IN"
      },
      "DXB": {
        "cityCode": "DXB",
        "countryCode": "AE"
      }
    },
    "aircraft": {
      "320": "AIRBUS A320",
      "321": "AIRBUS A321",
      "346": "AIRBUS A340-600",
      "359": "AIRBUS A350-900",
      "744": "BOEING 747-400",
      "74H": "BOEING 747-8"
    },
    "currencies": {
      "INR": "INDIAN RUPEE"
    },
    "carriers": {
      "XY": "FLYNAS",
      "UK": "VISTARA",
      "LH": "LUFTHANSA"
    }
  }
}';


?>