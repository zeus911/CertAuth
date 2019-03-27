<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Certs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('certs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('N');

            $table->string('subjectCommonName')->unique();
            $table->string('subjectContry');
            $table->string('subjectState');
            $table->string('subjectLocality');
            $table->string('subjectOrganization');
            $table->string('subjectOrganizationUnit');

            $table->string('hash');

            $table->string('issuerCN');
            $table->string('issuerContry');
            $table->string('issuerState');
            $table->string('issuerLocality');
            $table->string('issuerOrganization');
            $table->string('issuerOrganizationUnit');

            $table->string('version');

            $table->string('serialNumber')->unique();
            $table->string('serialNumberHex')->unique();

            $table->string('validFrom');
            $table->string('validTo');
            $table->string('validFrom_time_t');
            $table->string('validTo_time_t');

            $table->string('signatureTypeSN');
            $table->string('signatureTypeLN');
            $table->string('signatureTypeNID');

            $table->string('purposes');

            $table->string('extensionsBasicConstraints');
            //$table->string('extensionsNsCertType');
            $table->string('extensionsKeyUsage');
            $table->string('extensionsExtendedKeyUsage');
            $table->string('extensionsSubjectKeyIdentifier');
            $table->string('extensionsAuthorityKeyIdentifier');
            $table->string('extensionsSubjectAltName');
            $table->string('extensionsCrlDistributionPoints');

            $table->binary('certificateServerRequest');
            $table->binary('publicKey');
            $table->binary('privateKey');
            $table->binary('p12');

            $table->string('status');
            $table->string('expiryDate');
            $table->string('comments');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::drop('certs');
    }
}