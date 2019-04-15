<?php 
    namespace App\Controller;

    use App\Entity\Reservation;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    
    class ReservationController extends Controller {
        /**
         * @Route("/", name="reservations_list")
         * @Method({"GET"})
         */
        public function index() {
            $reservations= $this->getDoctrine()->getRepository(Reservation::class)->findAll();

            return $this->render('reservation/index.html.twig', array('reservations' => $reservations));
        }

        /**
         * @Route("/reservation/new", name="new_reservation")
         * Method({"GET", "POST"})
         */

        public function new(Request $request) {
            $reservation = new Reservation();

            $form = $this->createFormBuilder($reservation)
            ->add('title', TextType::class, array('attr' => 
            array('class' => 'form-control')))
            ->add('body', TextareaType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control')
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $reservation = $form->getData();

                $entityManager =  $this->getDoctrine()->getManager();
                $entityManager->persist($reservation);
                $entityManager->flush();

                return $this->redirectToRoute('reservations_list');
            }

            return $this->render('reservation/new.html.twig', array(
                'form' => $form->createView()
            ));
        }

        /**
         * @Route("/reservation/edit/{id}", name="edit_reservation")
         * Method({"GET", "POST"})
         */

        public function edit(Request $request, $id) {
            $reservation = new Reservation();
            $reservation = $this->getDoctrine()->getRepository(Reservation::class)->find($id);

            $form = $this->createFormBuilder($reservation)
            ->add('title', TextType::class, array('attr' => 
            array('class' => 'form-control')))
            ->add('body', TextareaType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control')
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Edit',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {

                $entityManager =  $this->getDoctrine()->getManager();
                $entityManager->flush();

                return $this->redirectToRoute('reservations_list');
            }

            return $this->render('reservation/edit.html.twig', array(
                'form' => $form->createView()
            ));
        }
        

        /**
         * @Route("/reservation/delete/{id}")
         * @Method({"DELETE"})
         */

        public function delete(Request $request, $id) {
            $reservation = $this->getDoctrine()->getRepository(Reservation::class)->find($id);

            $entityManager =  $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();

            $response = new Response();
            $response->send();
        }

        /**
         * @Route("/reservation/{id}", name="reservation_show")
         */

        public function show($id) {
            $reservation = $this->getDoctrine()->getRepository(Reservation::class)->find($id);

            return $this->render('reservation/show.html.twig', array('reservation' => $reservation));
        }

        // /**
        //  * @Route("/reservation/save")
        //  */
        // public function save() {
        //     $entityManager = $this->getDoctrine()->getManager();

        //     $reservation = new Reservation;
        //     $reservation->setTitle('reservation 1');
        //     $reservation->setBody('This is the body for reservation 1');

        //     $entityManager->persist($reservation);

        //     $entityManager->flush();

        //     return new Response('save an reservation with the id of'.$reservation->getId());
        // }
    }