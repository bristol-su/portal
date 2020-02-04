export default {
    authentication: {
        registration_identifier: {
            identifier: 'authentication.registration_identifier.identifier',
            validation: 'authentication.registration_identifier.validation',
        },
        password: {
            validation: 'authentication.password.validation'
        },
        verification: {
            required: 'authentication.verification.required'
        },
        authorization: {
            requiredAlreadyInControl: 'authentication.authorization.requiredAlreadyInControl',
            requiredAlreadyInData: 'authentication.authorization.requiredAlreadyInData',
        },
        messages: {
            notInData: 'authentication.messages.notInData',
            notInControl: 'authentication.messages.notInControl',
            alreadyRegistered: 'authentication.messages.alreadyRegistered'
        },
    },
    additional_attributes: {
        user: 'additional_attributes.user',
        group: 'additional_attributes.group',
        role: 'additional_attributes.role',
        position: 'additional_attributes.position'
    },
    welcome: {
        fillInRegInformation: 'welcome.fillInRegInformation',
        messages: {
            title: 'welcome.messages.title',
            subtitle: 'welcome.messages.subtitle'
        },
        attributes: 'welcome.attributes'
    },
    thirdPartyAuthentication: {
        providers: 'thirdPartyAuthentication.providers'
    }
};
