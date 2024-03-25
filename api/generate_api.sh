#!/bin/bash -eu

# ./generate_api
# backendのフォルダが`../backend`以外にある場合は
# ./generate_api ~/develop/backend
# など

set -eu

SCRIPT_DIR=$(cd $(dirname "$0")/.. && pwd)/nuxt-app
cd $(dirname $0)

#OPENAPI_DIR="${1:-..}/api"
OPENAPI_DIR="./"
echo ${SCRIPT_DIR}
cd "$OPENAPI_DIR"
OPENAPI_DIR="${PWD}"
FRONT_DIR="${SCRIPT_DIR}/api"

function generate() {
  docker run --rm \
    -v ${OPENAPI_DIR}:/openapi \
    -v ${FRONT_DIR}:/frontend \
    openapitools/openapi-generator-cli:v7.0.0 generate --skip-validate-spec \
    --enable-post-process-file \
    --model-package=model \
    --api-package=api \
    --generate-alias-as-model \
    --additional-properties supportsES6=true \
    --additional-properties withInterfaces=true \
    --additional-properties withSeparateModelsAndApi=true \
    -i "/openapi/$1" \
    -g typescript-fetch \
    -c "/openapi/openapi-generator-config.yml" \
    -o "/frontend"
}

generate "app/openapi.v1.yaml"
