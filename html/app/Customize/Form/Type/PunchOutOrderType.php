<?php

namespace Customize\Form\Type;

use Eccube\Form\Type\Shopping\OrderType as BaseOrderType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Eccube\Repository\TaxRuleRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormRegistryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PunchOutOrderType extends BaseOrderType
{
    private $requestStack;
    public function __construct(
        TaxRuleRepository $TaxRule,
        RequestStack $requestStack,
        FormFactoryInterface $formFactory,
        FormRegistryInterface $formRegistry,
        TokenStorageInterface $tokenStorage
    ) {
        parent::__construct($TaxRule, $requestStack, $formFactory, $formRegistry, $tokenStorage);
        $this->requestStack = $requestStack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();

            $request = $this->requestStack->getCurrentRequest();
            $sessionId = $request?->getSession()?->get('punchout_session_id');

            if ($sessionId) {
                $fields = [
                    'order_email',
                    'order_tel',
                    'order_zip01',
                    'order_zip02',
                    'order_addr01',
                    'order_addr02',
                ];

                foreach ($fields as $field) {
                    if ($form->has($field)) {
                        $form->add($field, null, [
                            'required' => false,
                        ]);
                    }
                }
            }
        });
    }
}
