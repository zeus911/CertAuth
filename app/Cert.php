<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cert extends Model
{
	protected $fillable = [
		'subjectCommonName',
		'subjectContry', 
		'subjectState', 
		'subjectLocality', 
		'subjectOrganization',
		'subjectOrganizationUnit',
		'hash', 
		'issuerCN', 
		'issuerContry', 
		'issuerState', 
		'issuerLocality', 
		'issuerOrganization',
		'issuerOrganizationUnit', 
		'version', 
		'serialNumber', 
		'serialNumberHex', 
		'validFrom', 
		'validTo', 
		'validFrom_time_t', 
		'validTo_time_t', 
		'signatureTypeSN',
		'signatureTypeLN', 
		'signatureTypeNID', 
		'purposes', 
		'extensionsBasicConstraints', 
		'extensionsNsCertType', 
		'extensionsKeyUsage', 
		'extensionsExtendedKeyUsage', 
		'extensionsSubjectKeyIdentifier', 
		'extensionsAuthorityKeyIdentifier',
		'extensionsSubjectAltName', 
		'extensionsCrlDistributionPoints', 
		'certificateServerRequest', 
		'publicKey',
		'privateKey',
		'p12', 
		'status', 
		'expiryDate', 
		'comments' 
	];
	
}
